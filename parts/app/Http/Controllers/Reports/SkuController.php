<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkuController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax())
        {
            $data = DB::select("EXEC [PartsProcessing].[bin].[sp_GetKitSKUReport]'{$request->days}'");

            return datatables($data)
                ->addIndexColumn()
                ->setRowId(function ($data) {
                    return $data->id;
                })
                ->toJson();
        }
        return view('reports.skus');
    }


}
