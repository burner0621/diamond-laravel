<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTypeDiamonds extends Model
{
    
    protected $table = 'material_type_diamonds';
    protected $fillable = [
        'material_id','material_type_id', 'mm_size', 'carat_weight','xy_size', 
    ];
    
    public function types() {
    	return $this->hasMany(MaterialType::class);
    }
    
    public function material() {
        return $this->belongsTo('App\Models\Material');
    }
}
