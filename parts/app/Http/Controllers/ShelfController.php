<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;

class ShelfController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Shelf::query();

            return datatables($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($shelf) {
                    return $shelf->getCreatedAt();
                })
                ->editColumn('boxes', function ($shelf) {
                    return $shelf->boxes()->count();
                })
                ->addColumn('actions', function () {
                    $btns = '<button class="qrcode btn btn-sm btn-dark"><i class="fas fa-print"></i></button>
                        <button class="btn btn-sm btn-default show-btn"><i class="fas fa-eye"></i></button>';
                    return $btns;
                })
                ->rawColumns(['actions'])
                ->setRowId(function ($data) {
                    return $data->shelf_id;
                })
                ->toJson();
        }

        return view('shelves.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Shelf
     */
    public function store(Request $request)
    {
        $shelf = new Shelf;
        $shelf->save();

        $shelf->update([
            'shelf_name' => 'SHELF'.$shelf->shelf_id
        ]);

        if ($request->json()) {
            return $shelf;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return ApplicationAlias|FactoryAlias|ViewAlias
     */
    public function show(Shelf $shelf)
    {
        $boxes= $shelf->boxes()->pluck('box_name','box_id');
        return view('shelves.show',compact('boxes','shelf'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelf $shelve)
    {
        return view('shelve.index', $shelve);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shelf $shelve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelf $shelve)
    {
        //
    }
}
