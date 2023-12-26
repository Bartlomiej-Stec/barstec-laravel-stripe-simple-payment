<?php

namespace Barstec\Stripe;

use Illuminate\Support\Facades\Facade;

final class StripeFacade extends Facade
{
    /**
     * Return Laravel Framework facade accessor name.
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'stripe';
    }
}