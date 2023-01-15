<?php

use App\Models\Product;
use App\Models\SellerWalletWithdrawal;
use App\Models\SettingGeneral;

if (!function_exists('guest_checkout')) {
    function guest_checkout()
    {
        return SettingGeneral::first() ? (SettingGeneral::first()->guest_checkout == null ? false : true) : false;
    }
}

if (!function_exists('pending_count')) {
    function pending_count()
    {
        return Product::where('status', 2)->count() ? Product::where('status', 2)->count() : 0;
    }
}

if (!function_exists('new_withdraw_count')) {
    function new_withdraw_count()
    {
        return SellerWalletWithdrawal::where('status', 0)->count() ? SellerWalletWithdrawal::where('status', 0)->count() : 0;
    }
}

if (!function_exists('get_period')) {
    function get_period($date)
    {
        $diff = abs(time() - strtotime($date));

        if ($diff > 365 * 60 * 60 * 24) {
            return floor($diff / (365 * 60 * 60 * 24)) . " years ago";
        }

        if ($diff > 30 * 60 * 60 * 24) {
            return floor($diff / (30 * 60 * 60 * 24)) . " months ago";
        }

        if ($diff > 60 * 60 * 24) {
            return floor($diff / (60 * 60 * 24)) . " days ago";
        }

        if ($diff > 60 * 60) {
            return floor($diff / (60 * 60)) . " hours ago";
        }

        if ($diff > 60) {
            return floor($diff / 60) . " minutes ago";
        }

        return floor($diff) . " seconds ago";
    }
}