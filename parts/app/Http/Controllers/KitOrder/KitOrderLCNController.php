<?php

namespace App\Http\Controllers\KitOrder;

use App\Http\Controllers\Controller;
use App\Models\KitOrder;
use App\Models\KitOrderLCN;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitOrderLCNController extends Controller
{
    public function edit(KitOrder $kitOrder): Factory|View|Application
    {
        $status = collect([
            (object) ['id'=>'In Process','name'=>'In Process'],
            (object) ['id'=>'Completed','name'=>'Completed']
        ]);

//        $kitLcns = collect(DB::select("EXEC [PartsProcessing].[ord].[sp_GetKitsOrderLCNs] '{$kitOrder->order_id}'"));
        $kitLcns = KitOrderLCN::query()->select('kit_lcn')->where('order_id',$kitOrder->order_id)->get();

        return view('kitOrderLCN.edit', compact('kitOrder','status','kitLcns'));
    }

    public function update(Request $request, KitOrder $kitOrder): \Illuminate\Http\JsonResponse
    {
        $kitOrder->reforder_id  =  $request->data['refOrder'];
        $kitOrder->order_status  =  $request->data['ordStatus'];
        $kitOrder->save();
        $authUser = auth()->id();

        KitOrderLCN::query()->select('kit_lcn')->where('order_id',$kitOrder->order_id)->get();

         foreach ($request->data['formData'] as $order){
             $data = DB::insert("EXEC [PartsProcessing].[prt].[sp_UpdateOrderLCNs] '{$kitOrder->order_id}', '{$authUser}', '{$order}'");
         }

        return response()->json(['success' => 'The LCNs has been update successfully'],200);

    }



}
