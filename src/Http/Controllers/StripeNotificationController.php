<?php

namespace Barstec\Stripe\Http\Controllers;


use Stripe\Webhook;
use Barstec\Stripe\Order;
use Illuminate\Http\Response;
use UnexpectedValueException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Barstec\Stripe\Http\Requests\StripeNotificationRequest;

class StripeNotificationController extends Controller
{
    public function handle(StripeNotificationRequest $request): Response
    {
        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('stripe.webhook_secret')
            );
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $order = new Order($event->type, $request->all());
        if ($order->statusChanged()) {
            $order->update();
        }
        return response('', 200);
    }
}
