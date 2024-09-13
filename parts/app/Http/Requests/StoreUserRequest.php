<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        $rules= [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('sqlsrv.prt.users')->ignore($this->user)],
            'role'  => ['required', Rule::in(['admin','employee'])],
        ];

        if ($this->method = 'PUT' or  $this->method() != 'PATCH'){
            if ($this->filled('password')) {
                $rules['password'] = ['confirmed', 'min:8'];
            }
        }else{
            $rules['password'] = ['confirmed', 'min:8'];
        }

        return $rules;
    }
}
