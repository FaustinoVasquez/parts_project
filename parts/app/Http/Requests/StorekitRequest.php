<?php

namespace App\Http\Requests;

use App\Models\Kit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StorekitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $rules = [
            'WorkCenterID'=>['required'],
            'LCN' => ['required','alpha_num','max:10',Rule::unique('sqlsrv.prt.PartsKitData','LCN')->ignore($this->kit)],
            'KitLCN'=>['required','string', 'max:50'],
            'Brand'=>['required','string', 'max:50'],
            'Model'=>['required','string', 'max:50'],
            'PartCategoryID'=>['required'],
            'PartSubCategoryID'=>['required'],
            'ProductSerialNumber'=>['sometimes'],
            'CountryID'=>['required'],
            'DateManufactured'=>['sometimes'],
            'Comments'=>['sometimes'],
//            'kitImage' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];


        return $rules;
    }


    public function createKit()
    {
        $kit = new Kit();
        $kit->fill([
            'WorkCenterID' => $this->WorkCenterID,
            'LCN' =>  $this->LCN,
            'KitLCN' => $this->KitLCN,
            'Brand' => $this->Brand,
            'Model' => $this->Model,
            'PartCategoryID' => $this->PartCategoryID,
            'ProductSerialNumber' => $this->ProductSerialNumber,
            'CountryID' => $this->CountryID,
            'DateManufactured' => $this->DateManufactured,
//            'IsCompleted' => $this->isCompleted,
//            'EstimatedRetailPrice' => $this->estimatedRetailPrice,
            'UserID' => auth()->id(),
            'PartSubCategoryID' => $this->PartSubCategoryID,
            'Comments' => $this->Comments,
            'KitImage' => 'http://test/',
        ]);
        $kit->save();

        return $kit;

    }

    public function updateKit($kit)
    {
       $kit->fill([
            'WorkCenterID' => $this->WorkCenterID,
            'LCN' =>  $this->LCN,
            'KitLCN' => $this->KitLCN,
            'Brand' => $this->Brand,
            'Model' => $this->Model,
            'PartCategoryID' => $this->PartCategoryID,
            'ProductSerialNumber' => $this->ProductSerialNumber,
            'CountryID' => $this->CountryID,
            'DateManufactured' => $this->DateManufactured,
            'UserID' => auth()->id(),
            'PartSubCategoryID' => $this->PartSubCategoryID,
            'Comments' => $this->Comments,
            'KitImage' => 'http://test/',
        ]);


       $kit->save();

    }
}
