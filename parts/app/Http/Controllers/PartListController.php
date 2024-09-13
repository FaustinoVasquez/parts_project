<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartListRequest;
use App\Http\Requests\UpdatePartListRequest;
use App\Models\PartList;

class PartListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorePartListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartList  $partList
     * @return \Illuminate\Http\Response
     */
    public function show(PartList $partList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartList  $partList
     * @return \Illuminate\Http\Response
     */
    public function edit(PartList $partList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartListRequest  $request
     * @param  \App\Models\PartList  $partList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartListRequest $request, PartList $partList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartList  $partList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartList $partList)
    {
        //
    }
}
