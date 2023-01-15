<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServiceDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'message',
        'attachment',
        'delivered_at',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id', 'id');
    }

    public function revision()
    {
        return $this->hasOne(OrderServiceRevisionRequest::class, 'delivery_id', 'id');
    }
}