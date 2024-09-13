<?php

namespace App\Http\Controllers\Oc;

use App\Http\Controllers\Controller;
use App\Http\Requests\OCConfigRequest;
use App\Models\OCConfig;
use App\Models\OCConfigList;
use App\Models\Tv;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OcDataController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OCConfigList::query();

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('actions', function () {
                    return '<div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-default show-btn"><i class="fas fa-eye"></i></a></div>';
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->tv_id;
                })
                ->toJson();
        }

        return view('oc.index');
    }

    public function show($id){
        $ocConfig = \DB::select(
            DB::raw("SELECT *FROM [oc].[fn_GetOCConfiguredItem] ('{$id}')")
        )[0];

        $tv = Tv::where('brand', $ocConfig->Brand)->where('model', $ocConfig->Model)->first();

        $partNumbers = DB::select(
            DB::raw("select * from [PartsProcessing].[oc].[fn_GetOCPartNumbers]('{$tv->id}')")
        );


        $ocAccessories = DB::select(
            DB::raw("SELECT *FROM [oc].[fn_GetOCAccessoriesList] ('{$id}')")
        );

        $mitSkus = DB::select(
            DB::raw("SELECT * FROM [PartsProcessing].[oc].[fn_GetOCSKUs] ()"));

        $ocConfig = collect($ocConfig);

        $ocAccessories = collect($ocAccessories)->map(function ($v) {
            return (object) $v;
        });

        return view("oc.show",compact('ocConfig','ocAccessories','mitSkus','partNumbers'));
    }

    public function create()
    {
        $brands = Tv::select('brand')->distinct('brand')->orderBy('brand', 'asc')->get();
//        $mitSkus = DB::select(
//            DB::raw("SELECT * FROM [PartsProcessing].[oc].[fn_GetOCSKUs] ()"));

        return view('oc.create', compact('brands'));
    }

    public function store(OCConfigRequest $request): \Illuminate\Http\JsonResponse
    {
        Debugbar::info($request->all());


//        $tv = Tv::select('id')->where('brand', $request->brand)->where('model', $request->model)->first();
//        $tv = "";

        $sku = \DB::scalar("SELECT [prt].[fn_GetOC_TVID] ('{$request->brand}', '{$request->model}')");

        if ($request->missing('id')) {
             $rowInserted = \DB::scalar("EXEC [oc].[sp_Create_OCConfig]'{$sku}', $request->partNumber, '{$request->mitSku}', '{$request->instructions}',''");
        }else{
             $rowUpdated = \DB::scalar("EXEC [oc].[sp_Update_OCConfig]'{$sku}', $request->partNumber, '{$request->mitSku}', '{$request->instructions}',''");
            $rowInserted = $request->id;
        }

//        if($rowInserted == "Record Exists"){
//            return response()->json([
//                'status' => 400,
//                'message' => 'The OcConfig Exists',
//            ]);
//        }

//        if ($request->missing('id')) {
//            $rowInserted = \DB::scalar("EXEC [oc].[sp_Create_OCConfig]$tv->id, $request->partNumber, '{$request->mitSku}', '{$request->instructions}',''");
//        }else{
//            $rowUpdated = \DB::scalar("EXEC [oc].[sp_Update_OCConfig]$request->id,$tv->id, $request->partNumber, '{$request->mitSku}', '{$request->instructions}',''");
//            $rowInserted = $request->id;
//        }

        if ($request->file('assemblyGuide')) {
            $file = $request->file('assemblyGuide');
            $extension = $file->getClientOriginalExtension();
            $name = $rowInserted . '-assemblyguide.' . $extension;
            $path = $rowInserted;
            $link = Storage::disk('sftp')->putFileAs($path, $file, $name);

            $occonfig = OCConfig::where('id', $rowInserted)->first();
            $occonfig['attachments'] = "http://part-storage.mitechnologiesinc.com/" . $link;
            $occonfig->update();
        }else{
            $files= Storage::disk('sftp')->allFiles($rowInserted);

            foreach ($files as $file){
                Storage::disk('sftp')->delete($file);
            }
            Storage::disk('sftp')->deleteDirectory($rowInserted);
        }
        return response()->json([
                'status' => 200,
                'message' => 'The OcConfig has been saved successfully',
                'data' => [
                    'accessory_id' => $rowInserted
                ]
            ]);
    }

    public function update(Request $request)
    {
//        $tv = Tv::select('id')->where('brand', $request->brand)->where('model', $request->model)->first();
        $sku = \DB::scalar("SELECT [prt].[fn_GetOC_TVID] ('{$request->brand}', '{$request->model}')");

        $rowUpdated = \DB::scalar("EXEC [oc].[sp_Update_OCConfigWithNoAttachement]$request->id,{$sku}, $request->partNumber, '{$request->mitSku}', '{$request->instructions}'");
        $rowInserted = $request->id;

        if ($request->file('assemblyGuide')) {
            $files= Storage::disk('sftp')->allFiles($rowInserted);
            foreach ($files as $file){
                Storage::disk('sftp')->delete($file);
            }
            Storage::disk('sftp')->deleteDirectory($rowInserted);

            $file = $request->file('assemblyGuide');
            $extension = $file->getClientOriginalExtension();
            $name = $rowInserted . '-assemblyguide.' . $extension;
            $path = $rowInserted;
            $link = Storage::disk('sftp')->putFileAs($path, $file, $name);

            $occonfig = OCConfig::where('id', $rowInserted)->first();
            $occonfig['attachments'] = "http://part-storage.mitechnologiesinc.com/" . $link;
            $occonfig->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'The OcConfig has been updated successfully',
        ]);

    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $rowDelete = \DB::select("EXEC [PartsProcessing].[oc].[sp_NukeOC_Config] '{$id}'");
            if ($rowDelete){
                $files= Storage::disk('sftp')->allFiles($id);
                foreach ($files as $file){
                    Storage::disk('sftp')->delete($file);
                }
                Storage::disk('sftp')->deleteDirectory($id);

                return response()->json([
                    'status' => 200,
                    'message' => 'The OcConfig has been delete successfully',
                ]);
            }else{
                throw new \ErrorException('Error found');
            }

        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }
}
