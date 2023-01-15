<?php

namespace App\View\Components;

use App\Models\Coupon;
use Illuminate\View\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutCart extends Component
{
    public $coupon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $locale = 'cart',
        public $products = null,
        public string $instance = 'default',
        public int $couponId = 0,
        public bool $hasCoupon = false
    )
    {
        $this->products = $products ?? Cart::instance($instance)->content();
        $this->coupon = Coupon::find($couponId);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkout-cart');
    }
}