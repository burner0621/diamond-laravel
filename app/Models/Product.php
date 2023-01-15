<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Traits\FormatPrices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Product extends Model
{
    use HasFactory, FormatPrices, SoftDeletes;

    protected $fillable = [
        'price',
        'description',
        'name',
        'vendor',
        'is_digital',
        'is_virtual',
        'is_madetoorder',
        'is_backorder',
        'is_trackingquantity',
        'category',
        'quantity',
        'product_images',
        'product_thumbnail',
        'slug',
        'status',
        'tax_option_id',
        'product_3dpreview',
        'product_attributes',
        'product_attribute_values',
        'digital_download_assets',
        'meta_title',
        'meta_description',
        'step_type',
        'step_group',
        'steps',
        'product_3dpreview_xyz'
    ];

    /*
    private static function getProductsAndMergeExtraProductsIfNotEnough(Collection $order_items)
    {
    $products = $order_items->map(fn($i) => $i->product);
    $order_items_quantity = $order_items->count();
    if($order_items_quantity < 100)
    {
    $diff = 100 - $order_items_quantity;

    $extra_products = Product::with('images')
    ->whereNotIn('id', $products->pluck('id'))
    ->limit($diff)
    ->get();

    $products = $products->merge($extra_products);
    }

    return $products;
    }
     */

    public static function getPriceInCents(float $price)
    {
        $price *= 100;
        return (int) $price;
    }
    /*
    public static function getTodaysDeals()
    {
    $order_items = OrderItem::select('id_product', DB::raw('sum(quantity) as total'))
    ->where('created_at', '>=', now()->subDay())
    ->groupBy('id_product')
    ->orderBy('total', 'description')
    ->with('product:id,name', 'product.images')
    ->limit(100)
    ->get();

    return Product::getProductsAndMergeExtraProductsIfNotEnough($order_items);
    }
     */

    public static function searchWithImages(string | null $search, string $category)
    {
        $q = Product::with('uploads');

        if ($category != 'all') {
            $q = $q->whereHas('product_category', function ($query) use ($category) {
                $query->where('category_name', $category);
            });
        }

        return $q->where('name', 'like', "%$search%")->where('status', 1)
            ->paginate(24);
    }

    public static function stringPriceToCents(string $price)
    {
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '', $price);
        return (int) $price;
    }

    /*
    public function replaceImagesIfExist(array|null $images)
    {
    if($images)
    {
    $this->images()->delete();
    Storage::deleteDirectory($this->id);

    $images = collect($images)->map(fn($i) => [
    'path' => 'storage/'.$i->store($this->id)
    ]);

    $this->images()->createMany($images->toArray());
    }
    }

    public function storeImages(array $images)
    {
    $images = collect($images)->map(fn($i, $k) => [
    'path' => 'storage/'.$i->store($this->id)
    ]);

    $this->images()->createMany($images->toArray());
    }

    public function deleteImagesInStorage()
    {
    Storage::deleteDirectory($this->id);
    }

    public function images()
    {
    return $this->hasMany(ProductImage::class, 'id_product')->orderBy('id', 'asc');
    }
     */

    public function tags()
    {
        return $this->hasMany(ProductTagsRelationship::class, 'id_product', 'id');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductsCategorie::class, 'category', 'id');
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'product_thumbnail', 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null,
        ]);
    }

    public function digital()
    {
        return $this->belongsTo(Upload::class, 'digital_download_assets', 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null,
            'file_original_name' => 'none',
            'extension' => 'none',
        ]);
    }

    public function getDigitalOriginalFileName()
    {
        return $this->name . "." . $this->digital->extension;
        // return $this->digital->file_original_name . "." . $this->asset->extension;
    }

    public function variants()
    {
        return $this->hasMany(ProductsVariant::class, 'product_id', 'id');
    }

    public function modelpreview()
    {
        return $this->belongsTo(Upload::class, 'product_3dpreview', 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null,
        ]);
    }

    public function attribute()
    {
        $attributesIds = explode(',', $this->product_attributes);
        $attributes = Attribute::whereIn('id', $attributesIds)->get();
        return $attributes;
    }

    public function attributeValue($attributeId = 0)
    {
        $attributesValueIds = explode(',', $this->product_attribute_values);

        $model = AttributeValue::whereIn('id', $attributesValueIds);
        if ($attributeId != 0) {
            $model = $model->where('attribute_id', $attributeId);
        }

        $attributesValues = $model->get();

        return $attributesValues;
    }

    public function taxPrice()
    {
        if ($this->tax_option_id) {
            return ProductsTaxOption::find($this->tax_option_id)->price;
        }

        return 0;
    }

    /**
     * get thumbnail file name from Upload model
     *
     * if thumbnail file name is 'none.png' on Upload model, return placeholder.jpg
     *
     * @return type
     **/
    public function getThumbnailFilePath()
    {
        if ($this->uploads->file_name != 'none.png') {
            $filename = str_replace('.' . $this->uploads->extension, Config::get('constants.product_thumbnail_suffix') . '.' . $this->uploads->extension, $this->uploads->file_name);

            return asset('uploads/all/' . $filename);
        }

        return asset('assets/img/placeholder.jpg');
    }

    public function digitalImage()
    {
        return $this->belongsTo(Upload::class, 'digital_download_assets');
    }
    // get user
    public function user()
    {
        return $this->belongsTo(User::class, 'vendor');
    }

    public function product_materials()
    {
        return $this->hasMany(ProductMaterial::class, 'product_id', 'id');
    }

    public function product_materials_by_material_id($material_id)
    {
        $product_materials = ProductMaterial::where('material_id', $material_id)
            ->where('product_id', $this->id)
            ->orderBy('product_attribute_value_id', 'asc')
            ->orderBy('material_type_id', 'asc')
            ->get();

        return $product_materials;
    }

    public function measurements()
    {
        return $this->hasMany(ProductMeasurementRelationship::class, 'product_id', 'id');
    }

    public function formatPriceFor($products)
    {
        $products->each(function ($product) {
            $count = ProductsVariant::where('product_id', $product->id)->count();
            $maxPrice = ProductsVariant::where('product_id', $product->id)->max('variant_price');
            $minPrice = ProductsVariant::where('product_id', $product->id)->min('variant_price');
            if ($count) {
                if ($minPrice != $maxPrice) {
                    $product->price = "$" . number_format($minPrice / 100, 2) . " - $" . number_format($maxPrice / 100, 2);
                } else {
                    $product->price = "$" . number_format($minPrice / 100, 2);
                }
            } else {
                $product->price = "$" . number_format($product->price / 100, 2);
            }
        });
    }
}
