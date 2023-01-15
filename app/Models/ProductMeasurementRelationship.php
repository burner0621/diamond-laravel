<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeasurementRelationship extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'product_id', 'measurement_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product_measurement()
    {
        return $this->belongsTo(ProductMeasurement::class, 'measurement_id', 'id');
    }
}
