<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
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
            'sitename' => ['nullable', 'max:255', 'string'],
            'meta_title' => ['nullable', 'max:255', 'string'],
            'meta_description' => ['nullable', 'max:255', 'string'],
            'twitter' => ['nullable', 'max:255', 'string'],
            'facebook' => ['nullable', 'max:255', 'string'],
            'instagram' => ['nullable', 'max:255', 'string'],
            'youtube' => ['nullable', 'max:255', 'string'],
            'stripe_key' => ['nullable', 'max:255', 'string'],
            'stripe_secret' => ['nullable', 'max:255', 'string'],            
            'mail_mailer' => ['nullable', 'max:255', 'string'],
            'mail_host' => ['nullable', 'max:255', 'string'],
            'mail_port' => ['nullable', 'max:255', 'string'],
            'mail_username' => ['nullable', 'max:255', 'string'],
            'mail_password' => ['nullable', 'max:255', 'string'],
            'mail_encryption' => ['nullable', 'max:255', 'string'],
            'mail_from_address' => ['nullable', 'max:255', 'string'],
            'mail_from_name' => ['nullable', 'max:255', 'string'],
            'recaptcha_site_key' => ['nullable', 'max:255', 'string'],
            'recaptcha_secret_key' => ['nullable', 'max:255', 'string'],
            'guest_checkout' => ['nullable', 'numeric'],
        ];
    }
}
