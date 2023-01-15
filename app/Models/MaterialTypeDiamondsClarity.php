<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTypeDiamondsClarity extends Model
{
    
    protected $table = 'material_type_diamonds_clarity';
    protected $fillable = [
        'name', 'letters' 
    ];
    
    public function clarity() {
        return $this->belongsTo('App\Models\MaterialTypeDiamondsPrices');
    }

    public function getClarityNameAttribute()
    {
        return $this->name . '(' . $this->letters . ')';
    }
}
