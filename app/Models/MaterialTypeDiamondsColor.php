<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTypeDiamondsColor extends Model
{
    
    protected $table = 'material_type_diamonds_color';
    protected $fillable = [
        'name', 'letters' 
    ];
    
    public function color() {
        return $this->belongsTo('App\Models\MaterialTypeDiamondsPrices');
    }

    public function getColorNameAttribute()
    {
        return $this->name . ' ' . $this->letters;
    }
}
