<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiamondStoreRequest extends FormRequest
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
            'material_type_id' => 'required|string',
            'mm_size' => 'required|string',
            'xy_size' => 'nullable|string',
            'carat_weight' => 'required|numeric',
        ];
    }
}
