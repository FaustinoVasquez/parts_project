<?php

namespace App\Http\Controllers\MasterSku;

use App\Http\Controllers\Controller;
use App\Models\Sku;
use Illuminate\Http\Request;

class MasterSKUHelper extends Controller
{
    public function getSkus(Request $request)
    {
        $data = Sku::query();

        if ($request->ajax()) {
            return datatables($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($item) {
                    return $item->ref_sku;
                })
                ->editColumn('kits_percent', function (Sku $sku) {
                    return $sku->kits_percent . " %";
                })
                ->editColumn('kits_count', function (Sku $sku) {
                    return '<a href="/sku/images/' . $sku->ref_sku . '" class="btn btn-info" target="_blank">
                            <i class="fas fa-images"></i>&nbsp;&nbsp;&nbsp;' . $sku->image_count . '</a>
                            <button class="btn btn-secondary kits-count">
                            <i class="fas fa-fw fa-layer-group"></i>&nbsp;&nbsp;&nbsp;' . $sku->qty . '</button>';
                })
                ->rawColumns(['image_count', 'kits_count'])
                ->setRowId(function ($data) {
                    return $data->ref_sku;
                })
                ->toJson();
        }
    }


    public function createMasterSKU(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        if ($request->ajax()) {
            try {
                $masterSku= \DB::select("EXEC [prt].[sp_GetMasterSKU]")[0];

                if($masterSku){
                    return response()->json($masterSku);
                }else{
                    throw new Exception;
                }
            }catch (Exception $e){
                return false;
            }
        }
        return false;
    }

    public function getSkusData(Request $request){

        //Necesito un SP que obtega todos los skus y comentarios de un MasterSKU, marca y modelo


        return response()->json($request->all());
    }


}
