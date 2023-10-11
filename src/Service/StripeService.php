<?php

namespace App\Service;

use App\Entity\Purchase;
use Stripe\PaymentIntent;

class StripeService
{
    public function getPaymentIntent(Purchase $purchase): PaymentIntent
    {
        $stripeSecretKey = 'sk_test_51Nuvx7LBiSBap6dTQ6ZjhjNisY1onrlrR7KkKPm7vBzNIhadx76ykDIFxhoGyERLfh9kO8RmrYTJGMcWKPmwIMGw001BdQvlE7';
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        return $stripe->paymentIntents->create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur',
        ]);
    }
}
