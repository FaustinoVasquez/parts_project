<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorekitRequest;
use App\Http\Requests\UpdatekitRequest;
use App\Http\Resources\KitResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Kit;
use App\Models\KitsData;
use App\Models\PartList;
use App\Models\SubCategory;
use App\Models\WorkCenter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class KitController extends Controller
{

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {

        if ($request->ajax()) {

            if (auth()->user()->role == 'employee') {
                $data = KitsData::query()->where('UserID', auth()->id());

//                if($request->model !== '0'){
//                    $data->where('model', $request->model);
//                }

            } else {
                $data = KitsData::query();

                //added=================
//                if($request->model !== '0'){
//                   $data->where('model', $request->model);
//                }
                //-------------------------
            }

            if($request->model !== '0'){
                $data->where('model', $request->model);
            }

            return datatables($data)
                ->addIndexColumn()
                ->editColumn('boxname', function ($kit) {
                    if(!$kit->BoxName){
                        return 'No Box Yet';
                    }
                    return $kit->BoxName;
                })
                ->editColumn('keywords', function ($kit) {
                    if(!$kit->keywords){
                        return 'No Keywords Yet';
                    }
                    return $kit->keywords;
                })
                ->editColumn('shelf_name', function ($kit) {
                    if(!$kit->shelf_name){
                        return 'No Shelf Yet';
                    }
                    return $kit->shelf_name;
                })
                ->editColumn('created_at', function ($kit) {
                    return $kit->created_at->toDateTimeString();
                })
                ->addColumn('actions', function () {
                    $btns ='<div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-info qrcode"><i class="fas fa-fw fa-print"></i></a>
                            <a href="#" class="btn btn-default show-btn"><i class="fas fa-eye"></i></a>';

                        if(auth()->user()->role =='admin'){
                           $btns .='<a href="#" class="btn btn-sm btn-primary sku-btn"><i class="fas fa-fw fa-bolt"></i></a>';
                        }

                    return $btns.'</div>';
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->kitid;
                })
                ->toJson();
        }

        return view('kits.index',[
            'brands' => Kit::query()->select('Brand')->distinct()->get(),
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('kits.create', [
            'kit' => new Kit,
            'workCenters' => WorkCenter::all(),
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'countries' => Country::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorekitRequest $request
     * @return RedirectResponse
     */
    public function store(StorekitRequest $request)
    {
        $kit = $request->createKit();
        $partlist = PartList::select('PartSequence','PartName', 'IsRequired')
            ->orderBy('PartSequence','asc')
            ->where('PartCategoryID', $kit->PartCategoryID)
            ->where('PartSubCategoryID', $kit->PartSubCategoryID)
            ->get()->mapWithKeys(function ($item) {
                return [$item['PartName'] => $item['IsRequired']];
            })->toArray();


        $kit->parts()->delete();


        foreach ($partlist as $partname => $value) {

            $kit->parts()->create([
                'PartName' => $partname,
                'PartWeightOz' => 0,
                'Created' => 0,
                'IsRequired' => $value,
                'UserID' => auth()->id()
            ]);
        }
        $firstPart = $kit->parts->first();

        $exitst = \DB::select("SELECT VerifiedReferenceExist FROM [PartsProcessing].[prt].[sp_GetLCNData]('$kit->LCN')")[0];

        if($exitst->VerifiedReferenceExist ==='1'){
            return redirect()->route('version.index', [
                'LCN' => $kit->LCN
            ]);
        }

        return redirect()->route('parts.edit', $firstPart)
            ->with('status', 'The Kit has been created, successfully, now we will create each part that compose it');;

    }

    /**
     * Display the specified resource.
     *
     * @param Kit $kit
     * @return Application|Factory|View
     */
    public function show(Kit $kit): View|Factory|Application
    {
        $parts = $kit->parts()->orderby('PartName')->get();
        return view('kits.show', compact('kit', 'parts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Kit $kit
     * @return Application|Factory|View
     */
    public function edit(kit $kit): View|Factory|Application
    {
        return view('kits.edit', [
            'kit' => $kit,
            'workCenters' => WorkCenter::all(),
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'countries' => Country::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorekitRequest $request
     * @param Kit $kit
     * @return RedirectResponse
     */
    public function update(StorekitRequest $request, Kit $kit): RedirectResponse
    {

        $request->updateKit($kit);

        return redirect()->route('kit-parts-update.edit', $kit)
            ->with('status', 'The Kit has been updated, successfully, now we will update each part that compose it');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kit $kit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Kit $kit)
    {
        try {
            $ret = \DB::select("EXEC [prt].[sp_NukeKit2]'$kit->KitLCN';");
        } catch (Exception $e) {

            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }

        return response()->json([
            'success' => 'The Kit has been deleted successfully',
        ], 200);

    }
}

//MTC99T0391
//MTC99T0391-KIT
