<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;


class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "slug",
        "author_id",
        "post",
        "tags_id",
        "categorie_id",
        "thumbnail",
        "status",
        "meta_title",
        "meta_description",
    ];

    public function storeImages($images)
    {
        $image = Storage::disk('public')->put('blog/post', $images); 
        $path = Storage::disk('public')->url('blog/post', $images);
        return $path;
    }

    public function tags()
    {
        return $this->hasMany(BlogPostTag::class, 'id_post' , 'id');
    }

    public function categories()
    {
        return $this->hasMany(BlogPostCategorie::class, 'id_post' , 'id');
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'thumbnail' , 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null
        ]);
    }
    public function postauthor()
    {
        return $this->belongsTo(User::class, 'author_id' , 'id')->withDefault([
            'name' => "Undefined",
        ]);
    }
}
