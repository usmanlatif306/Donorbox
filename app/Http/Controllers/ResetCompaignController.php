<?php

namespace App\Http\Controllers;

use App\Enums\DonationType;
use App\Models\Compaign;
use App\Models\CompaignReset;
use App\Models\Donation;
use Illuminate\Http\Request;

class ResetCompaignController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $compaign = Compaign::findOrFail($request->compaign_id);
        // total stripe donation states
        $total_stripe_raised = Donation::where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('amount');
        $total_stripe_raised_with_tax = Donation::where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted');

        // total paypal donation states
        $total_paypal_raised = Donation::where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('amount');
        $total_paypal_raised_with_tax = Donation::where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('culacted');

        $compaign->resets()->create([
            'last_stripe_total' => $total_stripe_raised,
            'last_stripe_total_with_tax' => $total_stripe_raised_with_tax,
            'last_paypal_total' => $total_paypal_raised,
            'last_paypal_total_with_tax' => $total_paypal_raised_with_tax,
        ]);

        return back()->with('success', 'Campaign Reset Successfully!');
    }
}
