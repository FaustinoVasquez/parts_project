<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersHelperController extends Controller
{
    public function GetLCN(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $lcn = $request->lcn;
            $data = DB::select("EXEC [ord].[sp_GetScannedLCNOrderSKU] '{$lcn}'");

            if($data){
                return response()->json($data[0]);
            }else{
                throw new Exception;
            }

        }catch (Exception $error){
            return response()->json($error->getMessage());
        }
    }

    public function deleteLCN(Request $request): \Illuminate\Http\JsonResponse
    {

        try{
            $orderID = $request->orderID;
            $skuLCN = $request->skuLCN;
            $type = $request->type;
            $data = DB::delete("EXEC [ord].[sp_deleteScannedKitLCN] '{$orderID}', '{$skuLCN}', '{$type}'");

            if($data){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data has been delete successfully',
                ]);
            }else{
                throw new Exception;
            }

        }catch (Exception $error){
            return response()->json($error->getMessage());
        }
    }

    public function postLCNs(Request $request): \Illuminate\Http\JsonResponse
    {
       $user= auth()->id();
       foreach ($request->all() as $item){
           $data = DB::select("EXEC [ord].[sp_SaveScannedLCNOrderSKU] '{$item[1]}', '$item[0]','{$user}' ");
      }
        return response()->json([
            'status' => 200,
            'message' => 'Data has been update successfully',
        ]);
    }

    public function deleteAllLCN(Request $request): \Illuminate\Http\JsonResponse
    {
//        dd($request->all());
        foreach ($request->all() as $item){
            $data = DB::delete("EXEC [ord].[sp_deleteScannedKitLCN] '{$item[0]}', '{$item[1]}', '{$item[2]}'");
        }
        return response()->json([
            'status' => 200,
            'message' => 'Data has been update successfully',
        ]);

    }

}
