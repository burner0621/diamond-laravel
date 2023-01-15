<?php

namespace App\Models;

use App\Models\Traits\FormatPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CouponUsageHistory extends Model
{
    use FormatPrices;

    protected $table = 'coupons_usage_history';

    protected $fillable = [
        'coupon_id', 
        'user_id',
        'order_id',
        'subtotal_cart',
        'subtotal_discount'
    ];

    public static function createCouponUsageHistory($order) {
        $user_id = Auth::user()->id;

        $coupon_code = $order->coupon_code;
        $arrCouponInfo = Coupon::getCouponByUser($coupon_code);
        $coupon = $arrCouponInfo['coupon'];

        if ($coupon == null) {
            return;
        }

        $data = array(
            'coupon_id'         => $coupon->id,
            'user_id'           => $user_id,
            'order_id'          => $order->id,
            'subtotal_cart'     => $order->total,
            'subtotal_discount' => $order->discount,
        );

        self::create($data);
    }
}
