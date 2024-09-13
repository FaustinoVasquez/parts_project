<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkCenterRequest;
use App\Http\Requests\UpdateWorkCenterRequest;
use App\Models\WorkCenter;

class WorkCenterController extends Controller
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
     * @param  \App\Http\Requests\StoreWorkCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkCenterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function show(WorkCenter $workCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkCenter $workCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkCenterRequest  $request
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkCenterRequest $request, WorkCenter $workCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkCenter $workCenter)
    {
        //
    }
}
