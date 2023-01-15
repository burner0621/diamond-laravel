<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function test() {
        dd(OrderItem::find(13)->productVariant->asset->file_name);
    }
}
