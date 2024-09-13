<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\PartList;
use App\Models\PartReference;
use Illuminate\Http\Request;

class KitPartController extends Controller
{


    public function edit(Kit $kit)
    {
        $parts = PartList::select('PartName','IsRequired')
            ->where('PartCategoryID',$kit->PartCategoryID)
            ->where('PartSubCategoryID',$kit->PartSubCategoryID)
            ->get();

        return view('admin.kitparts.edit',compact('kit','parts'));

    }

    public function update(Kit $kit)
    {
//        $request->validate([
//            'parts' => 'required|array|min:1'
//        ]);

//        $partlist = PartList::select('PartName','IsRequired')
//            ->where('PartCategoryID',$kit->PartCategoryID)
//            ->where('PartSubCategoryID',$kit->PartSubCategoryID)
//            ->get()->mapWithKeys(function($item){
//                return [$item['PartName'] => $item['IsRequired']];
//            })->toArray();
//
//
//        $kit->parts()->delete();
//
//       foreach ($partlist as $partname){
//
//           $kit->parts()->create([
//               'PartName' => $partname['PartName'],
//               'Created' => 0,
//               'IsRequired' => $partname['IsRequired'],
//               'UserID' =>auth()->id()
//           ]);
//       }
//        $firstPart = $kit->parts->first();
//
//        return redirect()->route('parts.edit',$firstPart)
//            ->with('status', 'The Kit has been created, successfully, now we will create each part that compose it');;

    }

}
