<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellersProfile extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sellers_profile';

    protected $fillable = [
        'user_id',
        'business_name',
        'whatsapp',
        'slogan',
        'about',
        'default_payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
