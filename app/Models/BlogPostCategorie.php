<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostCategorie extends Model
{
    use HasFactory;

    protected $table = 'blog_categories_relationships';

    protected $fillable = [
        'id_post',
        'id_category'
    ] ;
    
    public function category()
    {
        return $this->belongsTo(BlogCategorie::class, 'id_category' , 'id');
    }
}
