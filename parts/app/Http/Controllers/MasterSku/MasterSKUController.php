<?php

namespace App\Http\Controllers\MasterSku;

use App\Http\Controllers\Controller;
use App\Models\MasterSku;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSKUController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = MasterSku::query();

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('actions', function () {
                    $btns = '<div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-info edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-default show-btn"><i class="fas fa-trash-alt"></i></a>';
                    return $btns . '</div>';
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->ref_parentid;
                })
                ->toJson();
        }

        return view('masterSku.index');
    }


    public function edit($id)
    {

        $brands = Sku::query()->select('Brand')->distinct()->get();

        return view("masterSku.edit", compact('id','brands'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $skus = $request->data['skus'];
            $msSku = $request->data['MSku'];
            $parentID = MasterSku::where('MasterSKU',$msSku)->first();
            foreach ($skus as $sku => $note) {
                $data = DB::select("EXEC [PartsProcessing].[prt].[sp_Create_RefSkuComptability] '{$parentID['ref_parentid']}','{$sku}','{$note}'");
            }
            return response()->json(['success' => 'The SKUMaster has been update successfully'], 200);
        }
        return false;

    }
}
