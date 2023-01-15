<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServiceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'requirement_id',
        'answer',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id', 'id');
    }

    public function requirement()
    {
        return $this->belongsTo(ServiceRequirement::class, 'requirement_id', 'id')->withTrashed();
    }
}