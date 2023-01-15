<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'rating', 'review'];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id');
    }
}