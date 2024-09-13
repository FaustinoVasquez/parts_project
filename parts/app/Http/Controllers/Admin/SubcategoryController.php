<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if(isset($request->text)){
            $subcategories = Subcategory::where('PartCategoryID', $request->text)->get();
            return response()->json([
                'list'=> $subcategories,
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
}
