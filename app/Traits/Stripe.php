<?php

namespace App\Traits;

use Stripe\StripeClient;

trait Stripe
{
    public function stripe()
    {
        return new StripeClient(config('services.stripe.secret_key'));
    }
}
