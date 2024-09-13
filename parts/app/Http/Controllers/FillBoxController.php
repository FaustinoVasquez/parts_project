<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\BoxContent;
use App\Models\Kit;
use Illuminate\Http\Request;

class FillBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fillbox.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $boxId = $request->BoxID;
        $kits = $request->KitID;

//        $box = Box::where('box_id',$boxId)->first();

        try {
            $box = Box::where('box_id',$boxId)->first();
        } catch(\Illuminate\Database\QueryException $ex){
            $response = $ex->getMessage();
            return back()->with('danger','The box doesnt exists');
        }


        foreach ($kits as $kit_id){
            $kit = Kit::where('KitLCN',$kit_id)->first();
            if ($kit === null) {
                return back()->with('danger','The kit '.$kit_id.' information doesnt exists');
            }
        }


        foreach ($kits as $kit){
            BoxContent::create([
                'box_id' => $boxId,
                'kit_id' => Kit::where('KitLCN',$kit)->first()->KitID
            ]);
        }

        return back()->with('status','The Box saved');


        /// Un SP que valide que la caja exista, que no tenga kits
        /// UN SP que valide que el kit esista, que no este asignado a otra caja
        ///     que devuelva su id a partir del QR
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
