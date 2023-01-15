<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ServicePost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';
    
    public static $DELETED = 5;

    protected $fillable = [
        "name",
        "slug",
        "user_id",
        "content",
        "tags_id",
        "categorie_id",
        "thumbnail",
        "gallery",
    ];

    public function storeImages($images)
    {
        $image = Storage::disk('public')->put('service/post', $images);
        $path = Storage::disk('public')->url('service/post', $images);
        return $path;
    }

    public function tags()
    {
        return $this->hasMany(ServicePostTag::class, 'id_service', 'id');
    }

    public function categories()
    {
        return $this->hasMany(ServicePostCategorie::class, 'id_post', 'id');
    }

    public function packages()
    {
        return $this->hasMany(ServicePackage::class, 'service_id', 'id');
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'thumbnail', 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null,
        ]);
    }

    public function postauthor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => "Undefined",
        ]);
    }

    public function seller()
    {
        return $this->hasOne(SellersProfile::class, 'user_id', 'user_id');
    }

    public function requirements()
    {
        return $this->hasMany(ServiceRequirement::class, 'service_id', 'id');
    }
}