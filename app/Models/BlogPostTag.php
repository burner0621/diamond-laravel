<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    use HasFactory;

    protected $table = 'blog_tags_relationships';

    protected $fillable = [
        'id_post',
        'id_tag'
    ] ;
}
