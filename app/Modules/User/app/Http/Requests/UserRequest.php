<?php

namespace App\Modules\User\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [

            'username'=>'required|unique:manage_users|min:5',
            'email'=>'required|email|unique:manage_users',
            'first_name'=>'min:3|max:15',
            'last_name'=>'min:3|max:15', 
            'password'=>'required|same:confirm_password|min:9|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required',
        ];
    }
}
