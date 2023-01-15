<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_packages';

    protected $fillable = [
        "service_id",
        "name",
        "description",
        "price",
        "revisions",
        "delivery_time",
    ];

    public function service()
    {
        return $this->belongsTo(ServicePost::class, 'service_id', 'id');
    }
}