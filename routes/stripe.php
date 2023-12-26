<?php
use Barstec\Stripe\Http\Controllers\StripeNotificationController;

Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['api']], function () {
        Route::post(config('stripe.notification_route'), [StripeNotificationController::class, 'handle'])
            ->name('stripe.notification');
    });
});
