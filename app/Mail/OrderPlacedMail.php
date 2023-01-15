<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ShippingOption;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private Order $order)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // Set Tax
        $taxPrice = 0;
        $taxPrice = $this->order->tax_total / 100;

        // Set shipping price
        $shipping_price = 0;
        $shipping_price = $this->order->shipping_total / 100;
        

        return $this->subject('Your JewelryCG.com order #'.$this->order->order_id.'')
            ->view('emails.orders.placed')
            ->with([
                //'first_name' => $this->order->first_name,
                'first_name' => $this->order->billing_first_name,
                'orderID' => $this->order->order_id,
                'sub_total' => ($this->order->total/100),
                'total_price' => ($this->order->grand_total/100),
                'shipping_price' => $shipping_price,
                'tax_price' => ($this->order->tax_total/100),
                'billing_address1' => $this->order->billing_address1,
                'billing_address2' => $this->order->billing_address2,
                'billing_city' => $this->order->billing_city,
                'billing_state' => $this->order->billing_state,
                'billing_zipcode' => $this->order->billing_zipcode,
                'billing_country' => $this->order->billing_country,
                'shipping_address1' => $this->order->shipping_address1,
                'shipping_address2' => $this->order->shipping_address2,
                'shipping_city' => $this->order->shipping_city,
                'shipping_state' => $this->order->shipping_state,
                'shipping_zipcode' => $this->order->shipping_zipcode,
                'shipping_country' => $this->order->shipping_country,                
                'order_items' => $this->order->items->map(function($i) {
                    $i->getSelfWithProductInfo();
                    return $i->setPriceToFloat();
                })
            ]);
    }
}
