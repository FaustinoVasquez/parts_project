<?php

namespace App\Http\Controllers\Skus;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Sku;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SKUStepsController extends Controller
{

    public function create($brand,$model): Factory|View|Application
    {
        return view('skus.steps.create',[
            'brand' => $brand,
            'model' => $model,
            'countries' => Country::all(),
        ]);
    }


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'brand' => ['required'],
            'model'  => ['required'],
            'country' => ['required'],
            'productVersion'  => ['sometimes'],
            'chasis' => ['sometimes'],
            ]);

        $query = \DB::select("EXEC [PartsProcessing].[prt].[sp_CreateSKUVerifiedPartReferencesStep1]
            '{$request->brand}','{$request->model}','{$request->country}','{$request->productVersion}','{$request->chasis}'
        ")[0];

        return redirect()->route('steps.edit', $query->RefSKU);
    }

    public function edit(Sku $sku): Factory|View|Application
    {
        return view('skus.steps.edit',compact('sku'));
    }

    public function update(Request $request, Sku $sku)
    {

        $elements=array_slice($request->all(), 4);
        $offset =0;
        foreach (range(1,8) as $i){
            $element= array_slice($elements, $offset,6);

               $data = DB::select("EXEC [PartsProcessing].[prt].[sp_CreateSKUVerifiedPartReferencesStep2]
                '{$request->brand}',
                '{$request->model}',
                '{$sku->ref_sku}',
                '{$element['part'.$i.'Name']}',
                '{$element['part'.$i.'Ref1']}',
                '{$element['part'.$i.'Ref2']}',
                '{$element['part'.$i.'Ref3']}',
                '{$element['part'.$i.'Ref4']}',
                '{$element['part'.$i.'Ref5']}'
                ");

            $offset+=6;
        }


        return redirect()->route('skus.index')->with('status', 'The SKU "'.$sku->ref_sku.'" Has been created Successfully');

    }


}
///2571	Sony	KD50X80J	T500QVN04.2	1-009-724-31 , A5027308A	CTRL 50T39 CO4	AP-P265AM , 2955070605 , AP-P265AM B 100980021-00187206-00	DHUR-SY63 , 409B-DHURSY63	1-009-471-11
