<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::getOwnOrder();
        $orders->transform(fn($i) => $i->formatPrice());

        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        if (auth()->user()) {
            $order = Order::with('items')
                ->where('order_id', $orderId)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        } else {
            $order = Order::with('items')
                ->where('order_id', $orderId)
                ->firstOrFail();
        }

        return view('orders.show', compact('order'));
    }

    public function update(UpdateOrderRequest $req, Order $order)
    {
        $this->authorize('edit', $order);

        $order->adminUpdate($req);

        return redirect()->route('orders.show', $order);
    }

    /**
     * Track order page
     */
    public function trackOrder(Request $request)
    {
        if ($request->query('orderId') && $request->query('email')) {
            $order = Order::with('items', 'items.product:id,name,slug,product_thumbnail,is_digital,digital_download_assets')
                ->where('order_id', $request->query('orderId'))
                ->where('email', $request->query('email'))
                ->firstOrFail();
            return view('orders.show', compact('order'));
        } else {
            return view('trackorder');
        }
    }
}