<?php

namespace Barstec\Stripe\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StripeSessionExpired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $orderId;
    /**
     * Create a new event instance.
     */
    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }
}
