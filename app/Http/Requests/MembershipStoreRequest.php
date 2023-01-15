<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipStoreRequest extends FormRequest
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
            'name'                          => 'required|string|max:255',
            'price'                         => 'required',
            'price_monthly'                 => 'required',
            'included_downloads'            => 'required',
            'included_downloads_monthly'    => 'required',
            'unlimited_downloads'           => 'required|numeric',
        ];
    }
    
}
