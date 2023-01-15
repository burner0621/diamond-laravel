<?php

namespace App\Observers;

use App\Jobs\SendOrderFailedMail;
use App\Jobs\SendOrderPlacedMail;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order)
    {
        SendOrderPlacedMail::dispatch($order);
    }

    public function updated(Order $order)
    {
        //
    }

    public function deleted(Order $order)
    {
        SendOrderFailedMail::dispatch($order);
    }

    public function restored(Order $order)
    {
        //
    }

    public function forceDeleted(Order $order)
    {
        //
    }
}
