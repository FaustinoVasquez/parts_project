<?php

namespace App\Http\Controllers\Oc;

use App\Http\Controllers\Controller;
use App\Models\Tv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OCHelperController extends Controller
{
    public function getTvModels(Request $request): \Illuminate\Http\JsonResponse
    {
        $models = Tv::where('brand', $request->data)->select('model')->distinct('model')->orderBy('model', 'asc')->get();
        return response()->json($models);
    }

    public function getOCList(Request $request): bool|\Illuminate\Http\JsonResponse
    {

        if ($request->ajax()) {
            if ($request->brand) {
                $brand = $request->brand;
                $model = $request->model;
                $tv = Tv::where('Brand', $brand)->where('Model', $model)->first();
                $data = DB::select(
                    DB::raw("select * from [PartsProcessing].[oc].[fn_GetOCConfiguredList]('{$tv->SKU}')")
                );
            } else {
                $data = [];
            }

            return datatables($data)
                ->addIndexColumn()
                ->setRowId(function ($data) {
                    return $data->id;
                })
                ->toJson();
        }
        return false;
    }


    public function getOCPartNumbers(Request $request): \Illuminate\Http\JsonResponse
    {
        $brand = $request->data['brand'];
        $model =$request->data['model'];

        $tv = Tv::where('brand', $brand)->where('model', $model)->first();
        $data = DB::select(
            DB::raw("select * from [PartsProcessing].[oc].[fn_GetOCPartNumbers]('{$tv->id}')")
        );
        return response()->json($data);
    }

    public function getManufacturer(Request $request): \Illuminate\Http\JsonResponse
    {
        $partNumber = (int) $request->data['$partNumberSelected'];


        $manufacturer = DB::select(
            DB::raw("select * from [PartsProcessing].[oc].[fn_GetOCManufacturer]('{$partNumber}')")
        );

        return response()->json($manufacturer[0]->manufacturer);
    }

    public function getOCSkus(Request $request): \Illuminate\Http\JsonResponse
    {
        $brand = $request->data['brand'];
        $model =$request->data['model'];
        $oc_id = $request->data['OCId'];

        $tv = Tv::where('brand', $brand)->where('model', $model)->first();


        $data = DB::select(
            DB::raw("select * from [PartsProcessing].[oc].[fn_GetOCSKUsFiltered]('{$tv->id}',$oc_id)")
        );

        return response()->json($data);

    }



    public function getAPartName(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = DB::select(
            DB::raw("select DISTINCT PartName from [PartsProcessing].[oc].[fn_GetOCAccessoriesSKUs]()")
        );

        return response()->json($data);
    }

    public function getAMitSKu(Request $request): \Illuminate\Http\JsonResponse
    {
        //PartNumner == OC_id

        $data = DB::select(
            DB::raw("SELECT MITSKU,ProductSKU FROM [PartsProcessing].[oc].[fn_GetOCAccessoriesSKUs] () Where PartName='{$request->data}'")
        );
        return response()->json($data);
    }




    public function supdate(Request $request, $id)
    {
        dd($request->all());
    }


}
