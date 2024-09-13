<?php

namespace App\Http\Controllers\KitOrder;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitWebOrderController extends Controller
{
    public function index(Request $request): bool|\Illuminate\Http\JsonResponse
    {

        if ($request->ajax()) {
            try {
                $data = DB::statement("EXEC  [ord].[sp_ImportKitOrdersWeb]");
                if($data){
                    return response()->json(['success' => 'The orders has been Imported'],200);
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
