<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable= [
        'parent_id', 'category_name', 'category_excerpt',
        'slug', 'meta_title', 'meta_description'
    ];
}
