<?php

namespace App\Models;

use App\Models\Traits\FormatPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    use FormatPrices;

    protected $fillable = [
        'name', 'type', 'amount', 'limit', 'end_date'
    ];

    public static function getCouponByUser($coupon_code) {
        $user_id = Auth::check() ? Auth::user()->id : 0;

        $today = date('Y-m-d');
        $arrCoupons = self::where('name', $coupon_code)
            ->limit(1)
            ->get();

        if (count($arrCoupons) == 0) {
            return array(
                'coupon'    => null,
                'message'   => 'No Coupon Code : ' . $coupon_code
            );
        }

        $coupon = $arrCoupons[0];
        if ($coupon->end_date < $today) {
            return array(
                'coupon'    => null,
                'message'   => 'Coupon Code Expired'
            );
        }

        $count = CouponUsageHistory::where('user_id', $user_id)
            ->where('coupon_id', $coupon->id)
            ->count();

        if ($count >= $coupon->limit) {
            return array(
                'coupon'    => null,
                'message'   => 'You have exceeded limit of this coupon'
            );
        }

        return array(
            'coupon'    => $coupon,
            'message'   => ''
        );
    }
}
