<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
            // 'name' => 'prohibited',
            // 'email' => 'prohibited',
            // 'password' => 'prohibited',
            // 'address1' => 'required|string|max:255',
            // 'address2' => 'nullable|string|max:255',
            // 'city' => 'required|string|max:255', //
            // 'state' => 'required|string|max:255', //
            // 'country' => 'required|string|max:255', //
            // 'pin_code' => 'required|numeric|digits_between:4,6', //
            'buy_now_mode' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'First Name is empty.',
            'lname.required' => 'Last Name is empty.',
            'email.required' => 'Email is empty.',
            'phone.required' => 'Phone Number is empty.',
            'address1.required' => 'Address is empty.',
            'city.required' => 'City is empty.',
            'state.required' => 'State is empty.',
            'country.required' => 'Country is empty.',
            'pin_code.required' => 'PIN Code is empty.',
        ];
    }
}
