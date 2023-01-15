<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Stripe\Service\OrderService;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'address_shipping',
        'address_billing',
        'username',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id');
    }

    public function seller()
    {
        return $this->hasOne(SellersProfile::class, 'user_id');
    }

    public function getAttributeName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'avatar', 'id')->withDefault([
            'file_name' => "avatar.png",
            'extension' => "png",
            'id' => null,
        ]);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function message_notifications()
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function last_delivery_time()
    {
        $last_delivery = ServiceOrder::join('services', 'services.id', '=', 'orders_services.service_id')
            ->where('services.user_id', $this->id)
            ->where('orders_services.status', 5)
            ->orderBy('orders_services.updated_at', 'desc')
            ->select('orders_services.updated_at')
            ->first();

        if($last_delivery){
            return $last_delivery->updated_at;
        }else{
            return null;
        }
    }

    public function get_avg_response_time()
    {
        $avg_time = Message::selectRaw("(UNIX_TIMESTAMP(updated_at)-UNIX_TIMESTAMP(created_at))/ count(*) as avg_response_time")
            ->where('user_id', $this->id)
            ->where('is_seen', 1)
            ->first();

        if($avg_time){
            return $avg_time->avg_response_time / 1000 / 3600;
        }
        else {
            return '-';
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->uploads->getImageOptimizedFullName(100,100);
    }

    public function chatMessages()
    {
        return $this->hasMany(Message::class,'user_id');
    }
}
