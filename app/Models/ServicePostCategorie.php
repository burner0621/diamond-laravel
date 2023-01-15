<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePostCategorie extends Model
{
    use HasFactory;

    protected $table = 'service_categories_relationships';

    protected $fillable = [
        'id_post',
        'id_category'
    ] ;
    
    public function category()
    {
        return $this->belongsTo(ServiceCategorie::class, 'id_category' , 'id');
    }
}
