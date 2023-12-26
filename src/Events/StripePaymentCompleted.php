<?php

namespace Barstec\Stripe\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StripePaymentCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $orderData;
    public string $orderId;
    /**
     * Create a new event instance.
     */
    public function __construct(array $orderData, string $orderId)
    {
        $this->orderData = $orderData;
        $this->orderId = $orderId;
    }
}
