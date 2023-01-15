<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePostTag extends Model
{
    use HasFactory;

    protected $table = 'service_tags_relationships';

    protected $fillable = [
        'id_service',
        'id_tag',
    ];

    public function tag()
    {
        return $this->belongsTo(ServiceTags::class, 'id_tag', 'id');
    }
}