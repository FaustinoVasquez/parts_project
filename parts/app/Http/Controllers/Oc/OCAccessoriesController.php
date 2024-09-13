<?php

namespace App\Http\Controllers\Oc;

use App\Http\Controllers\Controller;
use App\Http\Requests\OCAccessoriesRequest;
use App\Models\OCAccessories;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class OCAccessoriesController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =[];
            if($request->OcConfigId){
                $id = (int) $request->OcConfigId;
                $data = OCAccessories::query()->where('oc_config_id',$id);
            }

           $disable = $request->isDisabled;

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('actions', function () use($disable) {
                    if($disable){
                        return '<div class="btn-group btn-group-sm">
                         <a href="#" class="btn btn-danger text-center btn-remove-acc"><i class="fas fa-trash-alt"></i></a></div>';
                    }else{
                        return '<div class="btn-group btn-group-sm">
                         <a href="#" class="btn btn-danger text-center btn-remove-acc disabled"><i class="fas fa-trash-alt"></i></a></div>';
                    }
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->id;
                })
                ->toJson();
        }
        return true;
    }


    /**
     * @throws \ErrorException
     */
    public function store(OCAccessoriesRequest $request): \Illuminate\Http\JsonResponse
    {
        Debugbar::info($request->all());
        try {
        $rowInserted = \DB::insert("EXEC [oc].[sp_Create_OCConfigAccessory] $request->ocId, '{$request->aPartName}', '{$request->aMitSKU}', $request->aQtyRequired,'{$request->aNotes}' ");

            if ($rowInserted){
                return response()->json([
                    'status' => 200,
                    'message' => 'The OcAccessories has been saved successfully',
                ]);
            }else{
                throw new \ErrorException('Error found');
            }

        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
        $rowDelete = \DB::select("EXEC [oc].[sp_NukeConfigAccessoryItem]'{$id}' ");

            if ($rowDelete){
                return response()->json([
                    'status' => 200,
                    'message' => 'The OcAccessories has been delete successfully',
                ]);
            }else{
                throw new \ErrorException('Error found');
            }

        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }
}
