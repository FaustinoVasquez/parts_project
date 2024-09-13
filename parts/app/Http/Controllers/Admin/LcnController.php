<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LcnController extends Controller
{
    public function index(Request $request)
    {

        if(isset($request->data)){
            return response()->json([
                'fields'=> $this->getFields($request->data),
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function getFields($text): array
    {
        $query = \DB::select("SELECT Brand, Model FROM [PartsProcessing].[prt].[sp_GetLCNData]('$text')")[0];
        return $fields = [
            'partsLcn'=> strtoupper($text.'-KIT'),
            'brand' => strtoupper($query->Brand),
            'model' => strtoupper($query->Model),
            ];
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSkus(Request $request)
    {
        $query = \DB::select("EXEC [PartsProcessing].[prt].[sp_GetVerifiedPartReferences]'$request->data'");
       return $query;
    }


    public function saveSkus(Request $request)
    {
        $query = \DB::selectt("EXEC [PartsProcessing].[prt].[sp_InsertPartReferences]'$request->sku'");
        return $request->all();
    }




}
