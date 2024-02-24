<?php

namespace App\Services;


class StripeService
{
    private $stripe;

    function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    }

    public function balance()
    {
        $balance = $this->stripe->balance->retrieve()->available[0];
        return [
            'amount' => $balance->amount / 100,
            'currency' => $balance->currency,
        ];
    }

    public function accounts($id = null)
    {
        if ($id) {
            return $this->stripe->accounts->retrieve($id, []);
        }
        return $this->stripe->accounts->all();
    }

    public function payout($amount, $currency = "usd")
    {
        try {
            $payout = $this->stripe->payouts->create([
                'amount' => $amount * 100,
                'currency' => $currency,
            ]);

            return [
                'success' => true,
                'payout' => $payout,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    public function update_payout($id)
    {
        try {
            $payout = $this->stripe->payouts->update(
                $id,
                ['metadata' => ['order_id' => '158']]
            );

            return [
                'success' => true,
                'payout' => $payout,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
