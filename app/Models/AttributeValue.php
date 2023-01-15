<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable= [
        
        'name',
        'attribute_id',
        'value',
        'slug',
    ];

    function image() {
        if ($this->attribute->type == 2) {
            return $this->hasOne(Upload::class, 'id', 'value');
        } else {
            return null;
        }
    }

    function attribute() {
        return $this->belongsTo('App\Models\Attribute', 'attribute_id', 'id');        
    }
}
