<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Stripe\StripeClient as Stripe;

class TWLStripe extends Model
{
    use HasFactory;

    public function subscribe(Stripe $stripe, $customer_id, $package, $subscription){
        $sub = $stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [
                ['price_data' => [
                        'currency' => 'usd',
                        'product' => $package['product_id'],
                        'recurring' => [
                            'interval' => 'month',
                            'interval_count' => $subscription['cycle']
                        ],
                        'unit_amount' => $subscription['total']
                ],
              ],
            ],
            'payment_settings' => [
                'payment_method_types' => ['card'],
            ]

          ]);

        return $sub;
    }

    public function createCustomer(Stripe $stripe, $email,$payment_method){
        $customer = $stripe->customers->create([
                        'email' => $email,
                        'payment_method' => $payment_method,
                        'invoice_settings' => [
                            'default_payment_method' => $payment_method
                        ]
                    ]);

        return $customer;
    }
}
