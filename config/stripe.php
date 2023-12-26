<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Notification route
    |--------------------------------------------------------------------------
    |
    | Here you may specify the route to the notification where Stripe sends  
    | notifications. The specified route has an /api prefix. 
    | For example, for /stripe/notification, the full path will be /api/stripe/notification.
    |
    */
    'notification_route' => '/stripe/notification',
    /*
    |--------------------------------------------------------------------------
    | Api key
    |--------------------------------------------------------------------------
    |
    | Here you may specify the Stripe api key. 
    | You can retrieve it from your Stripe settings
    |
    */
    'api_key' => env('STRIPE_API_KEY', ''),
    /*
    |--------------------------------------------------------------------------
    | Webhook secret
    |--------------------------------------------------------------------------
    |
    | Here you may specify the Stripe webhook secret. 
    | In your Stripe settings, create a new webhook with the value matching the notification_route
    | then copy the generated secret code into this field.
    |
    */
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
    /*
    |--------------------------------------------------------------------------
    | Default success return route
    |--------------------------------------------------------------------------
    |
    | This is the route name where the user will be redirected after a successful transaction.
    | If left empty, the user will be redirected to the path: '/' or to the URL specified while creating the transaction.
    |
    */
    'default_success_route' => '',
    /*
    |--------------------------------------------------------------------------
    | Default cancel route
    |--------------------------------------------------------------------------
    |
    | This is the route name where the user will be redirected after a unsuccessful transaction.
    | If left empty, the user will be redirected to the default return route
    |
    */
    'default_cancel_route' => '',
    /*
    |--------------------------------------------------------------------------
    | Default currency
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default currency used.
    |
    */
    'default_currency' => 'USD',
    /*
    |--------------------------------------------------------------------------
    | Route enabled
    |--------------------------------------------------------------------------
    |
    | Here you may enable or disable notification route. 
    | If the route is disabled, payment verification is not possible.
    |
    */
    'route_enabled' => true,
    /*
    |--------------------------------------------------------------------------
    | Table name
    |--------------------------------------------------------------------------
    |
    | Here you may specify table name with transactions
    |
    */
    'table_name' => 'stripe_transactions',
    /*
    |--------------------------------------------------------------------------
    | Additional input columns to be collected
    |--------------------------------------------------------------------------
    |
    | Here you may specify additional columns that should be collected 
    | while creating transaction (after first step). Each column must match key from additionalParams but use _ instead of .
    | Example: For key discounts.coupon column should be named: discounts_coupon
    |
    */
    'additional_input_columns' => [],
    /*
    |--------------------------------------------------------------------------
    | Additional transaction columns to be collected
    |--------------------------------------------------------------------------
    |
    | Here you may specify columns from transaction response that should be collected
    |
    */
    'response_columns' => [],
    /*
    |--------------------------------------------------------------------------
    | Default status
    |--------------------------------------------------------------------------
    |
    | Default status that will be set for transaction at the beginning
    |
    */
    'default_status' => 'created',
    /*
    |--------------------------------------------------------------------------
    | UI mode
    |--------------------------------------------------------------------------
    |
    | Specify ui_mode. It can be hosted or embedded.
    |
    */
    'ui_mode' => 'hosted'
];
