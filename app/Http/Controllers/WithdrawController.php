<?php

namespace App\Http\Controllers;

use App\Models\Compaign;
use App\Models\PaypalPayout;
use App\Models\StripePayout;
use App\Services\StripeService;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, StripeService $service)
    {
        $request->validate([
            'withdraw_amount' => ['required', 'numeric']
        ]);

        if (!$request->has('withdraw_amount') || (float) $request->withdraw_amount <= 0) {
            return back()->with('error', 'Withdraw amount should be greater than 0!');
        }

        if (!$request->has('compaign_id') || !Compaign::where('id', $request->compaign_id)->exists()) {
            return back()->with('error', 'Invalid Compaign!');
        }

        // if withdraw type is stripe
        if ($request->type === 'stripe') {
            if (!$request->has('stripe_withdraw_limit') || (float) $request->withdraw_amount > (float) $request->stripe_withdraw_limit) {
                return back()->with('error', 'Stripe withdraw limit exceeded. Please enter amount less than or equal to ' . currency_sign() . $request->stripe_withdraw_limit . '.');
            }

            $stripe_balance = $service->balance();

            if ((float) $request->withdraw_amount > $stripe_balance['amount']) {
                return back()->with('error', 'You have insufficient funds in your Stripe account for this transfer.');
            }

            $response = $service->payout((float) $request->withdraw_amount, $stripe_balance['currency']);
            if ($response['success']) {
                $payout = $response['payout'];
                StripePayout::create([
                    'compaign_id' => $request->compaign_id,
                    'payout_id' => $payout->id,
                    'amount' => $request->withdraw_amount,
                    'currency' => $payout->currency,
                    'balance_transaction' => $payout->balance_transaction,
                    'destination' => $payout->destination,
                    'method' => $payout->method,
                    'status' => $payout->status,
                    'type' => $payout->type,
                    'arrival_date' => date('Y-m-d', $payout->arrival_date),
                    'failure_code' => $payout->failure_code,
                    'failure_message' => $payout->failure_message,
                ]);

                return back()->with('success', 'Successfully withdraw donation from your stripe account. Estimate arrival date for donation to your external account is ' . date('Y-m-d', $payout->arrival_date) . '.');
            } else {
                return back()->with('error', $response['message']);
            }
        } else {
            if (!$request->has('paypal_withdraw_limit') || (float) $request->withdraw_amount > (float) $request->paypal_withdraw_limit) {
                return back()->with('error', 'Paypal withdraw limit exceeded. Please enter amount less than or equal to ' . currency_sign() . $request->paypal_withdraw_limit . '.');
            }

            PaypalPayout::create([
                'payout_id' => $request->payout_id,
                'compaign_id' => $request->compaign_id,
                'amount' => $request->withdraw_amount,
            ]);

            return back()->with('success', 'Successfully withdraw donation from your paypal account.');
        }

    }
}
