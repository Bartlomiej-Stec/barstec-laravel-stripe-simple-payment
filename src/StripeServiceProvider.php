<?php
namespace Barstec\Stripe;

use Illuminate\Support\ServiceProvider;

final class StripeServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'stripe');
    }

    private function getRoutesPath(): string
    {
        return realpath(__DIR__ . '/../routes/stripe.php');
    }

    private function getConfigPath(): string
    {
        return realpath(__DIR__ . '/../config/stripe.php');
    }

    private function loadRoutes(): void
    {
        if (config('stripe.route_enabled', true)) {
            $path = $this->getRoutesPath();
            $this->loadRoutesFrom($path);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            $this->getConfigPath() => config_path('stripe.php'),
        ], 'config');
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
