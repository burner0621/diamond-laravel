<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductMaterialStoreRequest extends FormRequest
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
            'product_id'        => 'required|integer',
            'material_type_id'  => 'required|string',
            'material_weight'   => 'string|max:100',
            'diamond_ids'   => 'nullable',
            'diamond_amount'   => 'nullable',
        ];
    }
}
