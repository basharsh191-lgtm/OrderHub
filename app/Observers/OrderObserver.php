<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }
    public function creating(Order $order):void
    {
        $order->order_number='ORD-' . now()->timestamp . '-' . random_int(100,999);

    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if($order->status==='cancelled')
            {
                Log::info("Order{$order->order_number} has been succssfully");
            }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        Log::info("Order{$order->order_number} has been deleted . Details :". json_encode($order->toArray()));
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
