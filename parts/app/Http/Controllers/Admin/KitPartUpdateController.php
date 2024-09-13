<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\PartList;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KitPartUpdateController extends Controller
{
    public function edit(Kit $kit)
    {
        $partsActive = PartList::select('PartName','IsRequired')
            ->where('PartCategoryID',$kit->PartCategoryID)
            ->where('PartSubCategoryID',$kit->PartSubCategoryID)
            ->pluck('PartName');

        foreach ($partsActive as $part){
          $parts[] = ['PartName' => $part,'active' =>$kit->parts()->where('PartName',$part)->exists()];
        }

        $parts = Collection::make($parts);


        return view('admin.kit_parts_update.edit',compact('kit','parts'));

    }

    public function update(Request $request, Kit $kit)
    {
        $request->validate([
            'parts' => 'required|array|min:1'
        ]);

        $kitPartsList = PartList::select('PartName','IsRequired')
            ->where('PartCategoryID',$kit->PartCategoryID)
            ->where('PartSubCategoryID',$kit->PartSubCategoryID)
            ->get()->mapWithKeys(function($item){
                return [$item['PartName'] => $item['IsRequired']];
            })->toArray();


        $allPartsList = PartList::select('PartName')
            ->where('PartCategoryID',$kit->PartCategoryID)
            ->where('PartSubCategoryID',$kit->PartSubCategoryID)
            ->get()->map(function($item){
                return $item['PartName'];
            })->toArray();

        $partsToUpdate = array_keys($request->parts);

        ///Delete Parts
        $partsToDelete = array_diff($allPartsList,$partsToUpdate);

        foreach ($partsToDelete as $partname){
            if($kit->parts()->where('PartName',$partname)->exists()){
                $kit->parts()->where('PartName',$partname)->delete();
            }
        }

        //Create Parts
        foreach ($partsToUpdate as $partname){
            if(!$kit->parts()->where('PartName',$partname)->exists()){

                $kit->parts()->create([
                'PartName' => $partname,
                'Created' => 0,
                'IsRequired' => $kitPartsList[$partname],
                'UserID' =>auth()->id()
            ]);
            }
        }

        foreach ($kit->parts as $partname){
            $partname->update([
                'Created' => false
            ]);
        }


//        foreach ($request->parts as $partname => $value){
//            if($kit->parts()->where(''))
//            dump($partname);
//
//            $kit->parts()->create([
//                'PartName' => $partname,
//                'Created' => 0,
//                'IsRequired' => $partlist[$partname],
//                'UserID' =>auth()->id()
//            ]);
//        }

//        dd($request->parts);
        $firstPart = $kit->parts->first();



        return redirect()->route('parts.edit',$firstPart)
            ->with('status', 'The Kit has been created, successfully, now we will create each part that compose it');;

    }
}
