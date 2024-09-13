<?php

namespace App\Http\Controllers\KitOrder;

use App\Http\Controllers\Controller;
use App\Models\KitOrder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;

class KitOrderController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {
        if ($request->ajax()) {
            $data = KitOrder::query();

            return datatables($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($kit) {
                    return $kit->created_at->toDateTimeString();
                })
                ->addColumn('actions', function () {
                    return  '<div class="btn-group btn-group-sm">
                             <a href="#" class="btn btn-info edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-default show-btn"><i class="fas fa-eye"></i></a></div>';

                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->order_id;
                })
                ->toJson();

        }
        return view('kitOrder.index');
    }

    public function create(Request $request)
    {
        return view('kitOrder.create');
    }

    public function store(Request $request)
    {

        $kitOrder = new KitOrder;
        $kitOrder->order_status= 'In Process';
        $kitOrder->created_by= $request->user()->id;
        $kitOrder->save();

        if($request->json()){
            return $kitOrder;
        }
        return false;
    }

    public function edit(KitOrder $kitOrder): Factory|View|Application
    {
        return view('kitOrder.edit', compact('kitOrder'));
    }

    public function update(Request $request,KitOrder $kitOrder,)
    {

        $kitOrder->reforder_id  =  $request->data['refOrder'];
        $kitOrder->channel  =  $request->data['orderChannel'];
        $kitOrder->save();

        $sku = array();
        $lcn = array();

        foreach ($request->data['formData'] as $key => $value) {
            if (str_starts_with($key, 'sku')) {
                $sku[$key] = $value;
            } elseif (str_starts_with($key, 'lcn')) {
                $lcn[$key] = $value;
            }
        }

        $newLcn = array();
        $newSku = array();

        foreach ($lcn as $key => $value) {
            if (str_contains($key, '[name]')) {
                $newKey = str_replace(array('[name]', 'lcn[', ']'), '', $key);
                $newLcn[$value] = (int) $lcn["lcn[$newKey][qty]"];
            }
        }
        foreach ($sku as $key => $value) {
            if (str_contains($key, '[name]')) {
                $newKey = str_replace(array('[name]', 'sku[', ']'), '', $key);
                $newSku[$value] = (int) $sku["sku[$newKey][qty]"];
            }
        }

            if(count($newLcn)){
                foreach ($newLcn as $key => $value) {
                    $data = DB::insert("EXEC [PartsProcessing].[prt].[sp_CreateKitOrderDetails] '{$kitOrder->order_id}', 'LCN', '{$key}', {$value}");
                }
            }
            if(count($newSku)){
                foreach ($newSku as $key => $value) {
                    $data = DB::insert("EXEC [PartsProcessing].[prt].[sp_CreateKitOrderDetails] '{$kitOrder->order_id}', 'SKU', '$key', {$value}");
                }
            }




            return response()->json(['success' => 'The SKUMaster has been update successfully'],200);

    }

}
