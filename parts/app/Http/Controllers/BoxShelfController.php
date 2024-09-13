<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Shelf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Throwable;

class BoxShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|FactoryAlias|View
     */
    public function index()
    {
        return view('boxShelf.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelf  $shelf
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Shelf $shelf)
    {
       foreach ($request->boxes as $boxObj){
           try {
               Box::find($boxObj['box_id'])->update([
                   'shelf_id'=> $shelf->shelf_id
               ]);
           } catch (Throwable $e) {
               return response()->json(
                    $e
               );
           }

       }

        return response()->json(
            'The Information has been saved Successfully'
        );
    }


    public function destroy(Request $request,Shelf $shelf): \Illuminate\Http\JsonResponse
    {

        foreach ($request->data as $boxObj){
            try {
                 \DB::select("EXEC [PartsProcessing].[bin].[sp_RemoveBoxFromShelf] '{$boxObj['id']}'");
            } catch (Throwable $e) {
                return response()->json(
                    $e
                );
            }
        };

        return response()->json(
            'The Boxes has been deleted Successfully'
        );
    }

}
