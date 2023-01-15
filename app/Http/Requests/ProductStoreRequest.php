<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $image_required = 'required';
        if(request()->routeIs('backend.products.update'))
        {
            $image_required = 'nullable';
        }

        return [
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'category' => 'required|string|max:24',
        ];
    }
}
