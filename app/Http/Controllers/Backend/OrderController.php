<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusChangedMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellersWalletHistory;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Mail;
use App\Models\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::getBasedOnUser();
        $orders->transform(fn($i) => $i->formatPrice());
        return view('backend.orders.list', compact('orders'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        $orders = OrderItem::select('orders.*', 'users.email')
            ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->where('order_items.status_fulfillment', '=', 1)
            ->groupBy('order_items.order_id')
            ->get();
        // ->toArray();
        // var_dump($orders);die;
        // $orders->transform(fn($i) => $i->formatPrice());
        return view('backend.orders.pending', compact('orders'));
    }

    /**
     * Return count of the pending orders.
     *
     * @return int count
     */
    public function pending_badge()
    {
        $count = OrderItem::select('order_items.order_id')
            ->join('orders', 'orders.order_id', '=', 'order_items.order_id')
            ->where('order_items.status_fulfillment', '=', 1)
            ->groupBy('order_items.order_id')
            ->get()
            ->toArray();

        return count($count);
    }

    public function status_tracking_set(Request $request, $id)
    {
        $rst = OrderItem::where('id', $id)->update(['status_tracking' => $request->status]);
        $order_id = OrderItem::where('id', $id)->first()->order_id;
        $order = Order::where('order_id', $order_id)->first();
        try {
            //code...
            Mail::to(Auth::user()->email)->send(new OrderStatusChangedMail($order));
        } catch (Exception $th) {
            echo ($th->getMessage());
        }

        return $rst;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.orders.show')->with('order', Order::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $orderItem = OrderItem::findOrFail($id);
        if($request -> status == 3) {
            Notification::create([
                'status' => 0,
                'user_id' => $order->user_id,
                'thumb' => 0,
                'message' => $orderItem->product_name ." ". $orderItem->product_variant_name . ' has been marked as delivered. View details.',
                'link' => '/orders/' . $order->order_id
            ]);
        }

        return OrderItem::where('id', $id)->update(['status_fulfillment' => $request->status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Mark as canceled
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mark_as_canceled(Request $request)
    {
        $order = Order::where('id', $request->order_id)->firstOrFail();

        $order->status_payment = 3; // canceled
        $order->save();

        // set seller balance
        $amount = 0;
        foreach ($order->items as $orderItem) {
            $seller = $orderItem->product->user->seller;
            if ($seller) {
                /* Mark seller wallet history status to 2 */
                $seller_wallet_history = SellersWalletHistory::where([
                    'user_id' => $seller->user_id,
                    'order_id' => $order->id,
                ])->first();

                $seller_wallet_history->status = 2;
                $seller_wallet_history->save();

                $seller->wallet = $seller->wallet - $seller_wallet_history->amount;
                $seller->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Mark as chargeback
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mark_as_chargeback(Request $request)
    {
        $order = Order::where('id', $request->order_id)->firstOrFail();

        $order->status_payment = 3; // chargeback
        $order->save();

        // set seller balance
        $amount = 0;
        foreach ($order->items as $orderItem) {
            $seller = $orderItem->product->user->seller;
            if ($seller) {
                /* Mark seller wallet history status to 3 */
                $seller_wallet_history = SellersWalletHistory::where([
                    'user_id' => $seller->user_id,
                    'order_id' => $order->id,
                ])->first();

                $seller_wallet_history->status = 3;
                $seller_wallet_history->save();

                $seller->wallet = $seller->wallet - $seller_wallet_history->amount;
                $seller->save();
            }
        }

        return response()->json(['status' => 'success']);
    }
}
