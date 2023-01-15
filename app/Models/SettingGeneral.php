<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingGeneral extends Model
{
    use HasFactory;
    protected $fillable = [
        'sitename',
        'meta_title',
        'meta_description',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'stripe_key',
        'stripe_secret',            
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'guest_checkout',
    ];
    protected $table = 'settings_general';
    
}
