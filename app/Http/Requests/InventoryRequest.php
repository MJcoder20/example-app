<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
            'name'=>'required|string',
            'city_id'=>'required|integer',
            'is_active'=>'integer|min:0|max:1',
            'phone'=>'required|unique:inventories|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];
    }
}
