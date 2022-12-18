<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsers extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        
        return [
            'email' => 'required|unique:users,email,'.$this->id,
            'password' => 'same:confirm-password',
            'name_ar' => 'required|unique:users,name->ar,'.$this->id,
            'name_en' => 'required|unique:users,name->en,'.$this->id,
            'phone' => 'required|unique:users,phone,'.$this->id,
            'roles_name' => 'required',
            // 'permission_name' => 'required',

        ];
    }

    public function messages()
    {
        
        return [
            'email.required' => trans('validation.required'),
            'email.unique' => trans('validation.unique'),
            'password.required' => trans('validation.required'),
            'name_ar.required' => trans('validation.required'),
            'name_ar.unique' => trans('validation.unique'),
            'name_en.required' => trans('validation.required'),
            'name_en.unique' => trans('validation.unique'),
            'roles_name.required' => trans('validation.required'),
            // 'permission_name.required' => trans('validation.required'),
        ];
    }
}
