<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeasurement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'units'];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->units;
    }
}
