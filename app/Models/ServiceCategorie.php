<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'category_name',
        'category_excerpt',
        'slug',
        'meta_title',
        'meta_description'
    ];
}
