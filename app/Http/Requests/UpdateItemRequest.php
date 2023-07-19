<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'name'=>['required'|Rule::unique('item')->where(function ($query) {
                $query->where('name', $this->name)
                   ->where('brand_id', $this->brand_id);
            })->ignore($this->item->id)],
            'image'=>'mimes:png,jpg,jpeg',
            'brand_id'=>'integer',
            'is_active'=>'integer|min:0|max:1',
        ];
    }
}
