<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellersWalletHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'order_id',
        'sale_type',
        'type',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id', 'id');
    }
}