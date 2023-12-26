<?php

namespace Barstec\Stripe\Events;

use Barstec\Stripe\Payload;
use Stripe\Checkout\Session;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class StripeTransactionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $transactionId;
    public Payload $payload;
    public Session $session;

    /**
     * Create a new event instance.
     */
    public function __construct(string $transactionId, Payload $payload, Session $session)
    {
        $this->transactionId = $transactionId;
        $this->payload = $payload;
        $this->session = $session;
    }
}
