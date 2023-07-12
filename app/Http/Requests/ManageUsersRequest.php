<?php

namespace App\Http\Requests;

use App\Models\ManageUsers;
use Illuminate\Foundation\Http\FormRequest;

class ManageUsersRequest extends FormRequest
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
            'is_admin'=>'integer|min:0|max:1',
            'is_active'=>'integer|min:0|max:1',
            'password'=>'required|min:9|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        
        ];
    }
}
