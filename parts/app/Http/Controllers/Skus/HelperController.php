<?php

namespace App\Http\Controllers\Skus;

use App\Http\Controllers\Controller;
use App\Models\KitsData;
use App\Models\Sku;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;
use Throwable;

class HelperController extends Controller
{
    public function getModels(Request $request)
    {
        return \DB::select("SELECT * FROM [PartsProcessing].[prt].[fn_GetVerifiedPartReferencesModels]('$request->text')");
    }

    public function getSKUModels(Request $request){
        return Sku::query()->select('model')->where('brand',$request->text)->distinct()->get();
    }

    public function getSkus(Request $request): JsonResponse
    {
        $data = \DB::select("SELECT * FROM [prt].[fn_GetVerifiedPartReferences] ('$request->brand','$request->model')");
        return datatables($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->ref_sku;
            })
            ->toJson();
    }

    public function getKits(Request $request): JsonResponse
    {

        $data = \DB::select("SELECT * FROM [prt].[fn_GetPartReferencesNonSKU] ('$request->brand','$request->model')");

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('actions', function () {
                $btns = '<button class="btn btn-sm btn-info add-btn"><i class="fas fa-plus-circle"></i></button>';
                return $btns;
            })
            ->rawColumns(['actions'])
            ->setRowId(function ($data) {
                return $data->KitID;
            })
            ->toJson();
    }

    public function getKitsWSku(Request $request): JsonResponse
    {
        $data = \DB::select("SELECT * FROM [prt].[fn_GetPartReferencesNonSKU] ('$request->brand','$request->model')");
        return datatables($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->KitID;
            })
            ->toJson();
    }

    public function getBulkKitsWSku(Request $request): JsonResponse
    {
        $data = \DB::select("SELECT * FROM [prt].[fn_GetPartReferencesNonSKU] ('$request->brand','$request->model')");
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('id', function ($data) {
                return $data->KitID;
            },0)
            ->setRowId(function ($data) {
                return $data->KitID;
            })
            ->toJson();
    }

    public function getImages(Sku $sku): Factory|View|Application
    {
        $images = \DB::select("EXEC [prt].[sp_GetKitSKUImages] '{$sku->ref_sku}'");

        return view('skus.images',compact('images', 'sku'));
    }

    /**
     * @throws Exception
     */
    public function getKitsBySku(Request $request): bool|JsonResponse
    {

        if ($request->ajax()) {
            $data = KitsData::query()->where('ref_sku', "{$request->sku}")->get();

            return datatables($data)
                ->addIndexColumn()
                ->editColumn('boxname', function ($kit) {
                    if (!$kit->BoxName) {
                        return 'No Box Yet';
                    }
                    return $kit->BoxName;
                })
                ->editColumn('keywords', function ($kit) {
                    if (!$kit->keywords) {
                        return 'No Keywords Yet';
                    }
                    return $kit->keywords;
                })
                ->editColumn('created_at', function ($kit) {
                    return $kit->created_at->toDateTimeString();
                })
                ->setRowId(function ($data) {
                    return $data->kitid;
                })
                ->toJson();
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function getSkuToKit(Request $request): bool|JsonResponse
    {
        if ($request->ajax()) {
            $data = \DB::select("SELECT * FROM [prt].[fn_GetPartReferencesSKU] ('$request->brand','$request->model')");

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('select', function ($row) use ($request) {
                    if($request->ref_sku){
                        if($request->ref_sku ===  $row->ref_sku){
                            return $row->ref_sku;
                        }
                    }

                    return 'disable';
                })
                ->rawColumns(['select'])
                ->setRowId(function ($data) {
                    return $data->ref_sku;
                })
                ->toJson();
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function kitUpdate(Request $request): bool|JsonResponse
    {
        if ($request->ajax()) {
            return \DB::select("EXEC [prt].[sp_UpdateKitSKU] '{$request->kit}','{$request->sku}'");
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function kitBulkUpdate(Request $request): bool|JsonResponse
    {
        if ($request->ajax()) {
            $kits = $request->kits;
            $sku = $request->sku;
            foreach ($kits as $kit){
                $data = DB::select("EXEC [PartsProcessing].[prt].[sp_UpdateKitSKUbyID] '{$kit}','{$sku}'");
//                try {
//                    \DB::select("EXEC [PartsProcessing].[prt].[sp_UpdateKitSKUbyID] '{$kit}','{$sku}'");
//                } catch (Throwable $e) {
//                    return response()->json(
//                        $e
//                    );
//                }
            }
            return response()->json(
                'The Kits has been update successfully'
            );
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function getKitData(Request $request): ?JsonResponse
    {
        if ($request->ajax()) {
        $data = \DB::select("SELECT * FROM [prt].[fn_GetKitRowData] ('{$request->kit}')");

            return datatables($data)
                ->addIndexColumn()
                ->setRowId(function ($kit) {
                    return $kit->kitid;
                })
                ->toJson();
        }
        return null;
    }


    public function updateKitData(Request $request, $sku): bool|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $updated= \DB::update("EXEC [prt].[sp_UpdatetVerifiedPartReferencesSKU]'{$sku}','{$request->sku["country_manufactured"]}','{$request->sku["chasis"]}','{$request->sku["product_version_number"]}','{$request->sku["opencell_sku"]}','{$request->sku["opencell_manufacturer"]}','{$request->sku["opencell_partref1"]}','{$request->sku["opencell_partref2"]}','{$request->sku["opencell_partref3"]}','{$request->sku["opencell_partref4"]}','{$request->sku["opencell_partref5"]}','{$request->sku["mainboard_partref1"]}','{$request->sku["mainboard_partref2"]}','{$request->sku["mainboard_partref3"]}','{$request->sku["mainboard_partref4"]}','{$request->sku["mainboard_partref5"]}','{$request->sku["powersupply_partref1"]}','{$request->sku["powersupply_partref2"]}','{$request->sku["powersupply_partref3"]}','{$request->sku["powersupply_partref4"]}','{$request->sku["powersupply_partref5"]}','{$request->sku["tconboard_partref1"]}','{$request->sku["tconboard_partref2"]}','{$request->sku["tconboard_partref3"]}','{$request->sku["tconboard_partref4"]}','{$request->sku["tconboard_partref5"]}','{$request->sku["irsensor_partref1"]}','{$request->sku["irsensor_partref2"]}','{$request->sku["irsensor_partref3"]}','{$request->sku["irsensor_partref4"]}','{$request->sku["irsensor_partref5"]}','{$request->sku["bluetoothmodule_partref1"]}','{$request->sku["bluetoothmodule_partref2"]}','{$request->sku["bluetoothmodule_partref3"]}','{$request->sku["bluetoothmodule_partref4"]}','{$request->sku["bluetoothmodule_partref5"]}','{$request->sku["wifimodule_partref1"]}','{$request->sku["wifimodule_partref2"]}','{$request->sku["wifimodule_partref3"]}','{$request->sku["wifimodule_partref4"]}','{$request->sku["wifimodule_partref5"]}'");

                if($updated){
                    return response()->json('The Sku has been updated');
                }else{
                    throw new Exception;
                }
            }catch (Exception $e){
                return false;
            }
        }
        return false;
    }

}
