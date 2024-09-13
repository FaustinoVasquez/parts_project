<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartImageRequest;
use App\Http\Requests\UpdatePartImageRequest;
use App\Models\PartImage;

class PartImageController extends Controller
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
     * @param  \App\Http\Requests\StorePartImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartImage  $partImage
     * @return \Illuminate\Http\Response
     */
    public function show(PartImage $partImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartImage  $partImage
     * @return \Illuminate\Http\Response
     */
    public function edit(PartImage $partImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartImageRequest  $request
     * @param  \App\Models\PartImage  $partImage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartImageRequest $request, PartImage $partImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartImage  $partImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartImage $partImage)
    {
        //
    }
}
