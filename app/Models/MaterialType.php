<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $fillable = [
        'material_id', 'type'
    ];
    
    protected $appends = [
        'material_name'
    ];

    public function material() {
    	return $this->belongsTo(Material::class);
    }

    /**
     * Get the material name attributes
     */
    public function getMaterialNameAttribute()
    {
        return $this->material?->name; 
    }

}
