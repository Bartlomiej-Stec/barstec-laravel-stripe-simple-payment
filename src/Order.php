<?php

namespace Barstec\Stripe;

use Barstec\Stripe\Events\StripePaymentCompleted;
use Barstec\Stripe\Events\StripeSessionExpired;
use Illuminate\Support\Facades\Log;
use Barstec\Stripe\Http\Models\Transaction;

class Order
{
    const STATUS_COMPLETED = "completed";
    const STATUS_EXPIRED = "expired";
    private array $orderData;
    private string $orderType;
    private Transaction $transaction;

    private function getValueFromNestedArray(string $string): mixed
    {
        $keys = explode('.', $string);
        $current = $this->orderData;

        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                return null;
            }
            $current = $current[$key];
        }

        return $current;
    }

    protected function getCustomerDetails(): array
    {
        $result = [];
        $result['email'] = $this->orderData['customer_details']['email'] ?? '';
        $result['name'] = $this->orderData['customer_details']['name'] ?? '';
        return $result;
    }

    public function statusChanged(): bool
    {
        return $this->transaction->status != $this->orderData['status'];
    }

    public function update(): void
    {
        switch ($this->orderType) {
            case 'checkout.session.completed':
                $customerDetails = $this->getCustomerDetails();
                $input = [
                    'status' => self::STATUS_COMPLETED,
                    'customer_name' => $customerDetails['name'],
                    'customer_email' => $customerDetails['email']
                ];
                foreach (config('stripe.response_columns') as $column) {
                    $input[str_replace('.', '_', $column)] = $this->getValueFromNestedArray($column);
                }
                $this->transaction->update($input);
                event(new StripePaymentCompleted($this->orderData, $this->orderData['id']));
                break;
            case 'checkout.session.expired':
                $this->transaction->update(['status' => self::STATUS_EXPIRED]);
                event(new StripeSessionExpired($this->orderData['id']));
                break;
        }
    }

    public function __construct(string $orderType, array $orderData)
    {
        $this->orderType = $orderType;
        $this->orderData = $orderData['data']['object'];
        $this->transaction = Transaction::where('order_id', $this->orderData['id'])->first();
    }
}