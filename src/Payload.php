<?php
namespace Barstec\Stripe;

use Illuminate\Support\Facades\Route;

class Payload
{
    private ?string $returnUrl = null;
    private ?string $cancelUrl = null;
    private array $additionalParams = [];
    private ?string $customerEmail = null;
    private ?string $customer = null;
    private ?string $locale = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?float $amount;
    private string $currency;
    private int $quantity = 1;
    private string $uiMode;
    private ?string $image = null;

    public function __construct()
    {
        if (Route::has(config('stripe.default_return_route'))) {
            $this->setReturnUrl(route(config('stripe.default_return_route')));
        }

        if (Route::has(config('stripe.default_negative_return_route'))) {
            $this->setCancelUrl(route(config('stripe.default_negative_return_route')));
        }
        $this->setCurrency(config('stripe.default_currency'));
        $this->setUiMode(config('stripe.ui_mode'));
    }

    public function setImage(?string $path): void
    {
        $this->image = $path;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getUiMode(): string
    {
        return $this->uiMode;
    }

    public function setUiMode(string $uiMode): void
    {
        $this->uiMode = $uiMode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = strtolower($currency);
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(?string $customerEmail): void
    {
        $this->customerEmail = $customerEmail;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(?string $customer): void
    {
        $this->customer = $customer;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): void
    {
        $this->locale = $locale;
    }

    public function getReturnUrl(): ?string
    {
        return $this->returnUrl;
    }

    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }

    public function getCancelUrl(): ?string
    {
        return $this->cancelUrl;
    }

    public function setCancelUrl(string $cancelUrl): void
    {
        $this->cancelUrl = $cancelUrl;
    }

    public function getAdditionalParams(): array
    {
        return $this->additionalParams;
    }

    public function setAdditionalParams(array $additionalParams): void
    {
        $this->additionalParams = $additionalParams;
    }

    public function addAdditionalParam(string $key, mixed $value): void
    {
        $this->additionalParams[$key] = $value;
    }
}