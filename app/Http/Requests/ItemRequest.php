<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            // 'name'=>'required',
            // 'image'=>'file|mimes:png,jpg,jpeg',
            
            // 'brand_id' => ['required', 'integer', Rule::unique('items')->where(function ($query) use (ItemRequest) {
            //     return $query->where('name', $this->input('name'));
            // })],
            // 'is_active'=>'integer|min:0|max:1',
        ];
    }
}
