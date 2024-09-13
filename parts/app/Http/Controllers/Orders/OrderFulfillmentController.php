<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\VwKitOrderLCN;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;

class OrderFulfillmentController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
         if ($request->ajax()){
             $data = VwKitOrderLCN::query();

             return datatables($data)
                 ->addIndexColumn()
                 ->setRowId(function ($data) {
                     return $data->order_id;
                 })
                 ->toJson();
         }

        return view('orders.index');
    }
}
