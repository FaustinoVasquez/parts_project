<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartReferenceRequest extends FormRequest
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
            'PartName' =>  ['required', 'string', 'max:50'],
            'PartRef1' =>  ['sometimes'],
            'PartRef2' => ['sometimes'],
            'PartRef3' =>  ['sometimes'],
        ];

         if ($this->IsRequired == '1'){
            $rules['PartWeightOz'] = ['required','numeric','between:0,999.99'];
            $rules['PartRef1'] = ['required'];
        }

        return $rules;

    }
}
