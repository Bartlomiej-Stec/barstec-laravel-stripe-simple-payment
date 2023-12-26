<?php

namespace Barstec\Stripe;

use Stripe\StripeClient;
use Illuminate\Http\RedirectResponse;

use Barstec\Stripe\Http\Models\Transaction;
use Barstec\Stripe\Exceptions\StripeException;
use Barstec\Stripe\Events\StripeTransactionCreated;

class Payment
{
    const HOSTED_UI_MODE = "hosted";
    private Payload $payload;

    private function extractAdditionalParams(array $params): array
    {
        $result = [];
        foreach ($params as $key => $value) {
            $current = &$result;
            $keys = explode('.', $key);
            foreach ($keys as $innerKey) {
                preg_match_all('/\w+/', $innerKey, $matches);
                $innerKeys = $matches[0];
                foreach ($innerKeys as $decodedKey) {
                    if (!isset($current[$decodedKey])) {
                        $current[$decodedKey] = [];
                    }
                    $current = &$current[$decodedKey];
                }
            }
            $current = $value;
        }
        return $result;
    }

    protected function removeNotSet(array &$input): void
    {
        foreach ($input as $key => &$value) {
            if (is_array($value)) {
                $this->removeNotSet($value);
            } else if (is_null($value))
                unset($input[$key]);
        }
    }

    protected function prepareRequestData(): array
    {
        $input = [
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->payload->getCurrency(),
                    'unit_amount' => intval($this->payload->getAmount() * 100),
                    'product_data' => [
                        'name' => $this->payload->getName(),
                        'description' => $this->payload->getDescription(),
                        'images' => [$this->payload->getImage()]
                    ]
                ],
                'quantity' => $this->payload->getQuantity()
            ]],
            'success_url' => $this->payload->getReturnUrl(),
            'cancel_url' => $this->payload->getCancelUrl(),
            'customer' => $this->payload->getCustomer(),
            'locale' => $this->payload->getLocale(),
            'customer_email' => $this->payload->getCustomerEmail(),
            'ui_mode' => $this->payload->getUiMode()
        ];
        $input = array_merge($input, $this->extractAdditionalParams($this->payload->getAdditionalParams()));
        $this->removeNotSet($input);
        return $input;
    }

    protected function verifyPayload(): void
    {
        if (is_null($this->payload->getName()))
            throw new StripeException('Name of item is required');

        if ($this->payload->getUiMode() == self::HOSTED_UI_MODE) {
            if (is_null($this->payload->getReturnUrl()))
                throw new StripeException('Return URL is required');
        }
    }

    public function redirect(): RedirectResponse
    {
        $this->verifyPayload();
        $inputData = $this->prepareRequestData();
        $stripe = new StripeClient(config('stripe.api_key'));
        $session = $stripe->checkout->sessions->create([$inputData]);
        $transaction = new Transaction();
        $transaction->createTransaction($this->payload, $session->id);
        event(new StripeTransactionCreated($session->id, $this->payload, $session));
        return redirect($session->url);
    }

    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }
}