<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductRequest;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\ProductMeasurementRelationship;
use App\Models\ProductsCategorie;
use App\Models\ProductsReview;
use App\Models\ProductsVariant;
use App\Models\Upload;
use App\Models\UserSearch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Crypt;

class ProductController extends Controller
{
    protected Product $product;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function searchCategory(Request $req)
    {
        $products = Product::searchWithImages($req->q, $req->category);
        $categories = ProductsCategorie::whereNull('parent_id')->get();

        $attributes = Attribute::has('values')->select('id', 'name', 'type')->get();
        return view('components.products-display', [
            'products' => $products,
            'categories' => $categories,
            'attrs' => $attributes,
        ]);
    }

    public function search(SearchProductRequest $req)
    {
        if (Auth::check()) {
            $search = new UserSearch;
            $search->user_id = Auth::user()->id;
            $search->query = json_encode(['category' => $req->category, 'query' => $req->q]);
            $search->save();
        }

        $products = Product::searchWithImages($req->q, $req->category);
        $this->product->formatPriceFor($products);
        $categories = ProductsCategorie::whereNull('parent_id')->get();

        $attributes = Attribute::has('values')->select('id', 'name', 'type')->get();

        return view('search', [
            'products' => $products,
            'categories' => $categories,
            'attrs' => $attributes,
        ]);
    }

    public function index()
    {
        return redirect()->route('shop_index');
    }

    public function products_index()
    {
        $products = Product::where('status', 1)->orderBy('id', 'DESC')->paginate(24);
        $products->each(function ($product) {
            $product->setPriceToFloat();
        });

        $categories = ProductsCategorie::whereNull('parent_id')->get();

        $attributes = Attribute::has('values')->select('id', 'name', 'type')->get();
        return view('products.list', [
            'products' => $products,
            'categories' => $categories,
            'attrs' => $attributes,
        ]);
    }

    /**
     * Filter producst by category and attribute_values
     *
     */
    public function filterProduct(Request $request)
    {
        if ($request->attrs && count($request->attrs) && $request->categories && count($request->categories)) {
            $attribute_query = '%' . implode(",", $request->attrs) . '%';
            $products = Product::join('products_variants', 'products.id', '=', 'products_variants.product_id')
                ->whereIn('category', $request->categories)
                ->where('status', 1)
                ->where(function ($query) use ($attribute_query) {
                    $query->where('products.product_attribute_values', 'like', $attribute_query)
                        ->orWhere('products_variants.variant_attribute_value', 'like', $attribute_query);
                })
                ->select('products.id', 'products.name', 'products.product_thumbnail', 'products.product_images',
                    'products.product_3dpreview', 'products.slug', 'products.price'
                )
                ->orderBy('products.id', 'DESC')->distinct('products.id')->paginate(24);
        } else if ($request->categories && count($request->categories)) {
            $products = Product::whereIn('category', $request->categories)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(24);
        } else if ($request->attrs && count($request->attrs)) {
            $attribute_query = '%' . implode(",", $request->attrs) . '%';
            $products = Product::join('products_variants', 'products.id', '=', 'products_variants.product_id')
                ->where('status', 1)
                ->where(function ($query) use ($attribute_query) {
                    $query->where('products.product_attribute_values', 'like', $attribute_query)
                        ->orWhere('products_variants.variant_attribute_value', 'like', $attribute_query);
                })
                ->select('products.id', 'products.name', 'products.product_thumbnail', 'products.product_images',
                    'products.product_3dpreview', 'products.slug', 'products.price'
                )
                ->orderBy('products.id', 'DESC')->distinct('products.id')->paginate(24);
        } else {
            $products = Product::where('status', 1)->orderBy('id', 'DESC')->paginate(24);
        }
        $products->each(function ($product) {
            $product->setPriceToFloat();
        });
        $products->withPath('/3d-models');
        $categories = ProductsCategorie::whereNull('parent_id')->get();

        $attributes = Attribute::has('values')->select('id', 'name', 'type')->get();
        return view('components.products-display', [
            'products' => $products,
            'categories' => $categories,
            'attrs' => $attributes,
        ]);
    }

    public function show($slug, Request $request)
    {
        try {
            $product = Product::with(['user', 'modelpreview'])->whereSlug($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $product = Product::with(['user', 'modelpreview'])->whereId($slug)->firstOrFail();
        }
        abort_if(!$product, 404);

        $product->setPriceToFloat();
        $uploads = Upload::whereIn('id', explode(',', $product->product_images))->get();
        $variants = ProductsVariant::with('product')->where('product_id', $product->id)->get();
        $maxPrice = ProductsVariant::where('product_id', $product->id)->max('variant_price') / 100;
        $minPrice = ProductsVariant::where('product_id', $product->id)->min('variant_price') / 100;

        if ($product->is_digital) {
            $order_item_count = OrderItem::whereHas('order', fn($query) => $query->where('user_id', Auth::id()))->where('product_id', $product->id)->where('product_variant_name', '')->count();

            if ($order_item_count > 0) {
                $product->buyable = false;
            } else {
                $product->buyable = true;
            }

            $variants->each(function ($variant) {
                $order_item_count = OrderItem::whereHas('order', fn($query) => $query->where('user_id', Auth::id()))->where('product_id', $variant->product_id)->where('product_variant', $variant->id)->count();

                if ($order_item_count > 0) {
                    $variant->buyable = false;
                } else {
                    $variant->buyable = true;
                }
            });
        } else {
            $product->buyable = true;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////
        // Product Review Info
        $user = Auth::user();
        $user_id = $user?->id;

        $purchase_count = Order::with('items')
            ->where('user_id', $user_id)
            ->where('status_payment', 2)
            ->whereRelation('items', 'product_id', $product->id)
            ->count();
        $product_reviewable = ($purchase_count > 0) ? true : false;

        $user_product_review = ProductsReview::where('product_id', $product->id)
            ->where('user_id', $user_id)
            ->first();

        $review_count = ProductsReview::where('product_id', $product->id)
            ->count();

        $average_rating = ProductsReview::select(
            DB::raw('AVG(rating) as average_rating')
        )->where('product_id', $product->id)
            ->first()->average_rating;
        $average_rating = number_format($average_rating ?: 0, 1);
        $arrReviewListing = ProductsReview::with('user')
            ->where('product_id', $product->id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        if ($request->ajax() && $request->page) {
            return view('products.show_reviews', compact(
                'arrReviewListing'
            ));
        }

        $arrProductMaterials = ProductMaterial::leftjoin('material_types', 'material_types.id', '=', 'product_materials.material_type_id')
            ->where('product_id', $product->id)
            ->where('product_materials.material_id', 2)
            ->get();

        $arrProductDiamonds = ProductMaterial::getDiamondsByProduct($product->id);
        $purchaseInfo = OrderItem::leftjoin('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->leftjoin('products_variants', 'order_items.product_variant', '=', 'products_variants.id')
            ->leftjoin('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.product_id', $product->id)
            ->where('orders.status_payment', 2)
            ->where('orders.user_id', $user_id)
            ->where(function ($query) {
                $query->select(DB::raw(1))
                    ->where('products.is_virtual', 1)
                    ->orWhere('products.is_digital', 1);
            })
            ->groupBy('products_variants.variant_attribute_value')
            ->select(DB::raw('COUNT(*) count, IF(products_variants.variant_attribute_value is NULL, 0, products_variants.variant_attribute_value) variant_attribute'))
            ->get();

        $attributes = Attribute::all();

        return view('products.show', compact(
            'product', 'uploads', 'variants', 'maxPrice', 'minPrice',
            'product_reviewable', 'user_product_review', 'review_count',
            'average_rating', 'arrReviewListing', 'arrProductMaterials', 'arrProductDiamonds', 'purchaseInfo', 'attributes'
        ));
    }

    public function download(Request $request)
    {
        $upload_id = Crypt::decryptString($request->upload_id);
        $order = Order::find($request->order_id);
        if ($order) {
            $upload = Upload::find($upload_id);
            return response()->download(public_path('uploads/all/') . $upload->file_name, $upload->file_original_name.".".$upload->extension);
        }
    }

    public function addReview(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;
        unset($data['_token']);

        $review_count = ProductsReview::where('user_id', $user_id)
            ->where('product_id', $data['product_id'])
            ->count();

        if ($review_count == 0) {
            ProductsReview::create($data);
        } else {
            ProductsReview::where('user_id', $user_id)
                ->where('product_id', $data['product_id'])
                ->update($data);
        }

        $product = Product::findOrFail($data['product_id']);

        return redirect()->route('products.show', $product->slug);
    }
}
