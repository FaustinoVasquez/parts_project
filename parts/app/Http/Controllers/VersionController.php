<?php

namespace App\Http\Controllers;

use App\Models\Kit;
use App\Models\PartReference;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        return view('version.index',[
            'skus' => DB::select("EXEC [PartsProcessing].[prt].[sp_GetVerifiedPartReferences]'$request->LCN'")
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $ref_sku = $request->Ref_Sku;

        $kit = Kit::where('KitLCN',$request->KitLCN)->first();
        $firstPart = $kit->parts->first();

        if ($ref_sku !== 'nodata') {

            $result =DB::select("EXEC [PartsProcessing].[prt].[sp_UpdatePartReferencesFromVerified]'$kit->LCN','$ref_sku'")[0];

            if ($result->Success){

                $CablesPart = $kit->parts->where('PartName','Cables')->first();

                return redirect()->route('parts.edit', $CablesPart)
                    ->with('status', 'The Kit and parts has been created, successfully');
            }

        }
         return redirect()->route('parts.edit', $firstPart)
                ->with('status', 'The Kit has been created, successfully, now we will create each part that compose it');

    }

}
