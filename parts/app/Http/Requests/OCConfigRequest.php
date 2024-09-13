<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class OCConfigRequest extends FormRequest
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
            "brand" => "required",
            "model" => "required",
//            "partNumber" => ["required",Rule::unique('sqlsrv.oc.OC_Config', 'oc_id')],
            "partNumber" => ['required'],
            "mitSku" => "required",
            "instructions" => "sometimes"
        ];

        if($this->hasFile('assemblyGuide'))
        {
            $rules["assemblyGuide"] ="required|file|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword";

        }

        return $rules;

    }

    public function messages()
    {
        return [
            'assemblyGuide.mimetypes' => 'The file must be of type Word.'
        ];
    }
}
