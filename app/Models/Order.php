<?php

namespace App\Models;

use Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'email',
        'total',
        'tax_total',
        'grand_total',
        'shipping_total',
        'tax',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address1',
        'shipping_address2',
        'shipping_city',
        'shipping_state',
        'shipping_zipcode',
        'shipping_country',
        'shipping_phonenumber',
        'billing_first_name',
        'billing_last_name',
        'billing_address1',
        'billing_address2',
        'billing_city',
        'billing_state',
        'billing_zipcode',
        'billing_country',
        'billing_phonenumber',
        'payment_intent',
        'status_payment',
        'status_payment_reason',
        'shipping_option_id',
        'tax_option_id',
    ];

    protected $keyType = 'string';

    public static function getBasedOnUser()
    {
        if (auth()->user()->role) {
            return Order::withCount('items')->orderBy('created_at', 'DESC')->paginate(10);
        }

        return auth()->user()->orders()->withCount('items')->orderBy('created_at', 'DESC')->paginate(10);
    }

    public static function getOwnOrder()
    {
        return auth()->user()->orders()->withCount('items')->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function restoreProductsQuantity()
    {
        Cart::content()->map(fn($i, $k) => $i->model->increment('quantity', $i->quantity));
    }

    public function restoreCartItems()
    {
        $orderItems = $this->items;

        foreach ($orderItems as $item) {
            if (!$item->product_variant) {
                Cart::add($item->product->id, $item->product->name, $item->quantity, $item->price / 100)->associate(Product::class);
            } else {
                Cart::add($item->product->id, $item->product->name, $item->quantity, $item->price / 100, 0, ['id' => $item->product_variant, 'name' => $item->productVariant->name, 'price' => $item->price / 100])->associate(Product::class);
            }
        }
    }

    public function totalPrice()
    {
        $totalPrice = 0;

        foreach ($this->items as $item) {
            $totalPrice += $item->quantity * $item->price;
        }

        return $totalPrice;
    }

    public function formatPrice()
    {
        $this->total_price = number_format($this->totalPrice() / 100, 2);
        return $this;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}