<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartReferenceRequest;
use App\Http\Requests\UpdatePartReferenceRequest;
use App\Models\PartReference;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PartReferenceController extends Controller
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
     * @param  \App\Http\Requests\StorePartReferenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartReferenceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartReference  $partReference
     * @return \Illuminate\Http\Response
     */
    public function show(PartReference $partReference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartReference  $part
     * @return Application|Factory|View
     */
    public function edit(PartReference $part)
    {
        $kitID = $part->kit->KitID;

        $totalParts = PartReference::where('KitID',$kitID)->count();
        $editParts = PartReference::where('KitID',$kitID)->where('Created',false)->count();
        $editPart = ($totalParts - $editParts)+1;

        return view('parts.edit',[
            'part' => $part,
            'totalParts' => $totalParts,
            'editPart' => $editPart,
            'kitID' => $kitID
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartReferenceRequest  $request
     * @param  \App\Models\PartReference  $part
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePartReferenceRequest $request, PartReference $part)
    {
        if(isset($request['PartValue'])){
            if ($request['PartValue'] == 'on'){
                $part->PartValue = 1;
            }
            else{
                $part->PartValue = 0;
            }
        }

        if($request['isSkipped']){
            $part->delete();
        }else {
            $part->PartValue = $request['PartValue'];
            $part->PartWeightOZ = $request['PartWeightOz'];
            $part->PartRef1 = $request['PartRef1'];
            $part->PartRef2 = $request['PartRef2'];
            $part->PartRef3 = $request['PartRef3'];
            $part->Created = 1;
            $part->UserID = auth()->id();
            $part->save();
        }

        $kit = $part->KitID;
        $partRest = PartReference::where('KitID',$kit)->where('Created',0)->first();



        if ($partRest) {
            return redirect()->route('parts.edit',$partRest);
        }
        return redirect()->route('kits.index')
            ->with('status','All parts has been created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartReference  $partReference
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartReference $partReference)
    {
        //
    }
}



