<?php

namespace App\Http\Controllers\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\KitsData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequirementsController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {

        if ($request->ajax()) {

            if (auth()->user()->role == 'employee') {
                $data = KitsData::query()->where('UserID', auth()->id());

//                if($request->model !== '0'){
//                    $data->where('model', $request->model);
//                }

            } else {
                $data = KitsData::query();

                //added=================
//                if($request->model !== '0'){
//                   $data->where('model', $request->model);
//                }
                //-------------------------
            }

            if($request->model !== '0'){
                $data->where('model', $request->model);
            }

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($item) {
                    return $item->kitid;
                })
                ->editColumn('boxname', function ($kit) {
                    if(!$kit->BoxName){
                        return 'No Box Yet';
                    }
                    return $kit->BoxName;
                })
                ->editColumn('keywords', function ($kit) {
                    if(!$kit->keywords){
                        return 'No Keywords Yet';
                    }
                    return $kit->keywords;
                })
                ->editColumn('shelf_name', function ($kit) {
                    if(!$kit->shelf_name){
                        return 'No Shelf Yet';
                    }
                    return $kit->shelf_name;
                })
//                ->addColumn('actions', function () {
//                    $btns ='<div class="btn-group btn-group-sm">
//                            <a href="#" class="btn btn-success select-btn"><i class="fas fa-check-circle"></i></a>';
//                    return $btns.'</div>';
//                })
                ->rawColumns(['checkbox'])
                ->setRowId(function ($data) {
                    return $data->kitid;
                })
                ->toJson();
        }

        return view('requirements.index',[
            'brands' => Kit::query()->select('Brand')->distinct()->get(),
        ]);
    }
}
