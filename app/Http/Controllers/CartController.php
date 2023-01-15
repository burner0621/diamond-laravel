<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemEditRequest;
use App\Http\Requests\RemoveFromWishlistRequest;
use App\Http\Requests\StoreProductCartRequest;
use App\Models\Product;
use App\Models\ProductsVariant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        // Cart::instance('default')->erase(auth()->id());
        // Cart::instance('default')->destroy();
        // dd(Cart::content());
        if (Auth::check()) {
            Cart::restore(auth()->id());
            foreach (Cart::content() as $item) {
                if (isset($item->options['variant_attribute_value'])) {
                    $variant = ProductsVariant::where('product_id', $item->id)->where('variant_attribute_value', $item->options['variant_attribute_value'])->first();

                    if (!$variant) {
                        Cart::remove($item->rowId);
                        continue;
                    }

                    Cart::update($item->rowId, [
                        'price' => $variant->variant_price / 100,
                        'name' => $item->model->name,
                        'qty' => $item->qty,
                        'options' => [
                            'id' => $variant->id,
                            'variant_attribute_value' => $variant->variant_attribute_value,
                            'name' => $variant->variant_name,
                            'price' => $variant->variant_price / 100,
                        ],
                    ]);
                } else {
                    Cart::update($item->rowId, [
                        'price' => $item->model->price / 100,
                        'name' => $item->model->name,
                        'qty' => $item->qty,
                    ]);
                }
            }
            Cart::store(auth()->id());
        }

        return view('cart');
    }

    public function store(StoreProductCartRequest $req)
    {
        $product = Product::findOrFail($req->id_product);

        if ($product->quantity < 1 && $product->is_trackingquantity) {
            return back();
        }

        if ($req->variant_attribute_value) {
            $variant = ProductsVariant::where('product_id', $req->id_product)->where('variant_attribute_value', $req->variant_attribute_value)->first();

            Cart::instance('default')->add(
                $product->id,
                $product->name,
                1,
                $variant->variant_price / 100,
                0,
                ['id' => $variant->id, 'name' => $variant->variant_name, 'price' => $variant->variant_price / 100, 'variant_attribute_value' => $variant->variant_attribute_value]
            )
                ->associate(Product::class);
        } else {
            Cart::instance('default')->add(
                $product->id,
                $product->name,
                1,
                $product->price / 100
            )
                ->associate(Product::class);
        }

        if (auth()->check()) {
            Cart::restore(auth()->id());
            Cart::store(auth()->id());
        }

        // return redirect()->route('products.show', $product->slug)->with(['message' => 'Successfully added to Cart!']);

        return view('products.cart-drawer')->with(['items' => Cart::content()]);
    }

    public function buyNow(StoreProductCartRequest $req)
    {
        $product = Product::findOrFail($req->id_product);
        Cart::instance('buy_now')->destroy();
        Cart::instance('buy_now')->add(
            $product->id,
            $product->name,
            1,
            $product->price / 100
        )
            ->associate(Product::class);

        Cart::restore(auth()->id());
        Cart::store(auth()->id());

        return view('checkout', ['buy_now_mode' => 1]);
    }

    public function editQty(CartItemEditRequest $req)
    {
        if (auth()->check()) {
            Cart::restore(auth()->id());
            Cart::update($req->row_id, $req->quantity);
            Cart::store(auth()->id());
        }

        return true;
    }

    public function removeProduct($product_id)
    {
        try
        {
            Cart::instance('default')->remove($product_id);
            if (auth()->check()) {
                Cart::restore(auth()->id());
                Cart::remove($product_id);
                Cart::store(auth()->id());
            }
        } finally {
            return redirect()->route('cart.index');
        }
    }

    public function wishlist()
    {
        Cart::instance('wishlist')->restore(auth()->id());
        Cart::instance('wishlist')->store(auth()->id());
        return view('users.wishlist');
    }

    public function wishlistStore(StoreProductCartRequest $req)
    {
        $product = Product::findOrFail($req->id_product);

        if ($product->quantity < 1 && $product->is_trackingquantity) {
            return back();
        }

        if ($req->variant_attribute_value) {
            $variant = ProductsVariant::where('variant_attribute_value', $req->variant_attribute_value)->first();

            Cart::instance('wishlist')->add(
                $product->id,
                $product->name,
                1,
                $variant->variant_price / 100,
                0,
                ['id' => $variant->id, 'name' => $variant->variant_name, 'price' => $variant->variant_price / 100]
            )
                ->associate(Product::class);
        } else {
            Cart::instance('wishlist')->add(
                $product->id,
                $product->name,
                1,
                $product->price / 100
            )
                ->associate(Product::class);
        }

        Cart::restore(auth()->id());
        Cart::store(auth()->id());

        return redirect()->route('products.show', $product->slug)->with(['wishlist-message' => 'Successfully added to Wishlist!']);
    }

    public function removeFromWishlist(RemoveFromWishlistRequest $req)
    {
        Cart::instance('wishlist')->restore(auth()->id());
        Cart::remove($req->row_id);
        Cart::store(auth()->id());

        return back();
    }

    public function destroy($id)
    {
        Cart::instance('default')->restore(auth()->id());
        Cart::remove($id);
        Cart::store(auth()->id());

        return true;
    }

    public function wishlistToCart(RemoveFromWishlistRequest $req)
    {
        $product = Cart::instance('wishlist')->get($req->row_id)->model;

        Cart::instance('wishlist')->restore(auth()->id());
        Cart::remove($req->row_id);
        Cart::store(auth()->id());

        Cart::instance('default')->add(
            $product->id,
            $product->name,
            1,
            $product->price / 100
        )
            ->associate(Product::class);

        Cart::restore(auth()->id());
        Cart::store(auth()->id());

        return redirect()->route('cart.wishlist');
    }

    public function getCount()
    {
        return Cart::content()->count();
    }
}