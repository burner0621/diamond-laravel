<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_name',
        'variant_price',
        'variant_quantity',
        'variant_sku',
        'variant_thumbnail',
        'variant_assets',
        'variant_attribute_value',
        'digital_download_assets',
        'digital_download_assets_count',
        'digital_download_assets_limit',
    ];

    public function uploads()
    {
        return $this->hasOne(Upload::class, 'id', 'variant_thumbnail');
    }

    public function asset()
    {
        return $this->hasOne(Upload::class, 'id', 'digital_download_assets')->withDefault([
            'file_name' => "none",
            'file_original_name' => 'none',
            'id' => null,
            'extension' => 'none'
        ]);
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getAssetOriginalFileName()
    {
        return $this->product->name . " - " . $this->variant_name . "." . $this->asset->extension;
        // return $this->asset->file_original_name . "." . $this->asset->extension;
    }

    public function setPriceToFloat()
    {
        $this->variant_price = number_format($this->variant_price / 100, 2);
        return $this;        
    }

    public static function stringPriceToCents(string $variant_price)
    {
        $variant_price = str_replace('.', '', $variant_price);
        $variant_price = str_replace(',', '', $variant_price);
        return (int) $variant_price;
    }
}
