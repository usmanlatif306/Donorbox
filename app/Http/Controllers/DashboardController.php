<?php

namespace App\Http\Controllers;

use App\Enums\DonationType;
use App\Models\Compaign;
use App\Models\Donation;
use App\Models\PaypalPayout;
use App\Models\StripePayout;
use App\Services\StripeService;
use App\Traits\DaysBetweenDates;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use DaysBetweenDates;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stripe = new StripeService();

        // getting starting and ending dates based on duration type
        if (!$request->has('type') || $request->type === 'all') {
            $starting_date = Donation::whereIn('compaign_id', active_compaigns())->select(['created_at'])->oldest()->first()?->created_at;
            $ending_date = Donation::whereIn('compaign_id', active_compaigns())->select(['created_at'])->latest()->first()?->created_at;
        } elseif ($request->type === 'week') {
            $starting_date = now()->subDays(7);
        } elseif ($request->type === 'month') {
            $starting_date = now()->subDays(30);
        } elseif ($request->type === 'quarter') {
            $starting_date = now()->subMonths(4);
        } elseif ($request->type === '6_months') {
            $starting_date = now()->subMonths(6);
        } elseif ($request->type === 'year') {
            $starting_date = now()->subMonths(12);
        }
        $ending_date = now();

        // getting formatted dates and data based on duration type
        $performance['formatted_days'] = $this->days($starting_date, $ending_date);
        $performance['formatted_dates'] = $this->dates($starting_date, $ending_date);
        $performance['formatted_data'] = [];
        foreach ($performance['formatted_dates'] as $date) {
            $performance['formatted_data'][] = Donation::whereIn('compaign_id', active_compaigns())->whereDate('created_at', $date)->sum('amount');
        }

        // choosing colour for each compaign, getting formatted data for each compaign based on duration type
        $colours = ["primary", "success", "warning", "danger", "info", "primary", "success", "warning", "danger", "info"];
        $compaigns = [];
        $formatted_compaigns = [];
        $formatted_compaigns['categories'][] = "";
        $formatted_compaigns['stripe_donations'][] = 0;
        $formatted_compaigns['paypal_donations'][] = 0;
        foreach (Compaign::with(['reset'])->withSum('stripe_payouts', 'amount')->whereIn('id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->latest()->get() as $idx => $compaign) {
            $item['colour'] = $colours[$idx];
            unset($colours[$idx]);
            $item['compaign'] = $compaign;
            $item['id'] = $compaign->id;

            // calculations at last reset
            $total_stripe_raised_at_reset = $compaign->reset?->last_stripe_total ?? 0;
            $total_paypal_raised_at_reset = $compaign->reset?->last_paypal_total ?? 0;
            $item['total_stripe_raised_at_reset'] = $total_stripe_raised_at_reset;
            $item['total_paypal_raised_at_reset'] = $total_paypal_raised_at_reset;
            $item['total_raised_at_reset'] = $total_stripe_raised_at_reset + $total_paypal_raised_at_reset;
            $total_stripe_raised_with_tax_at_reset = $compaign->reset?->last_stripe_total_with_tax ?? 0;
            $total_paypal_raised_with_tax_at_reset = $compaign->reset?->last_paypal_total_with_tax ?? 0;
            $item['total_stripe_raised_with_tax_at_reset'] = $total_stripe_raised_with_tax_at_reset;
            $item['total_paypal_raised_with_tax_at_reset'] = $total_paypal_raised_with_tax_at_reset;
            $item['total_raised_with_tax_at_reset'] = $total_stripe_raised_with_tax_at_reset + $total_paypal_raised_with_tax_at_reset;
            $total_stripe_withdraw_amount_at_reset = $compaign->reset?->total_stripe_withdraw_amount ?? 0;
            // $total_stripe_withdraw_amount_at_reset = $compaign->reset?->last_stripe_total_with_tax ?? 0;
            $total_paypal_withdraw_amount_at_reset = $compaign->reset?->total_paypal_withdraw_amount ?? 0;
            // $total_paypal_withdraw_amount_at_reset = $compaign->reset?->last_paypal_total_with_tax ?? 0;
            $item['total_stripe_withdraw_amount_at_reset'] = $total_stripe_withdraw_amount_at_reset;
            $item['total_paypal_withdraw_amount_at_reset'] = $total_paypal_withdraw_amount_at_reset;
            $item['total_withdraw_at_reset'] = $total_stripe_withdraw_amount_at_reset + $total_paypal_withdraw_amount_at_reset;

            // total amount raised without tax all time
            $total_raised = $item['total_raised_without_tax_all_time'] = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            // total amount raised without tax after reset
            $item['total_raised_after_reset'] = $total_raised - $item['total_raised_at_reset'];

            // total amount raised with tax all time
            $item['total_raised_with_tax_all_time'] = (double) Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('culacted');

            // total amount raised with tax after reset
            $total_raised_with_tax_after_reset = $item['total_raised_with_tax_all_time'] - $item['total_raised_with_tax_at_reset'];
            $item['total_raised_with_tax_after_reset'] = str_contains($total_raised_with_tax_after_reset, '-') ? 0 : $total_raised_with_tax_after_reset;

            // total stripe withdraw all time
            $stripe_withdraw_all_time = StripePayout::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            // current stripe withdraw will be calculated by total stripe withdraw - total stripe withdraw amount at reset
            $item['stripe_withdraw'] = $stripe_withdraw_all_time - $item['total_stripe_withdraw_amount_at_reset'];

            // total paypal withdraw all time
            $paypal_withdraw_all_time = PaypalPayout::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            // current paypal withdraw will be calculated by total paypal withdraw - total paypal withdraw amount at reset
            $item['paypal_withdraw'] = $paypal_withdraw_all_time - $item['total_paypal_withdraw_amount_at_reset'];

            // current total withdraw after reset
            $item['total_withdraw'] = $item['stripe_withdraw'] + $item['paypal_withdraw'];
            $remaining_balance = $item['total_raised_with_tax_after_reset'] - $item['total_withdraw'];
            $item['remaining_balance'] = str_contains($remaining_balance, '-') ? 0 : $remaining_balance;

            // calculating stripe remaining withdraw limit
            $stripe_raised = (float) Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted');
            $stripe_raised_after_reset = $stripe_raised - $total_stripe_raised_with_tax_at_reset;
            $item['stripe_raised_after_reset'] = str_contains($stripe_raised_after_reset, '-') ? 0 : $stripe_raised_after_reset;
            $stripe_withdraw = (float) StripePayout::where('compaign_id', $compaign->id)->sum('amount');
            $item['total_stripe_withdraw_after_reset'] = $stripe_withdraw - $item['total_stripe_withdraw_amount_at_reset'];
            $stripe_withdraw_limit = $item['stripe_raised_after_reset'] - $item['total_stripe_withdraw_after_reset'];
            $item['stripe_withdraw_limit'] = str_contains($stripe_withdraw_limit, '-') ? 0 : $stripe_withdraw_limit;

            // calculating paypal remaining withdraw limit
            $paypal_raised = (float) Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('culacted');
            $paypal_raised_after_reset = $paypal_raised - $total_paypal_raised_with_tax_at_reset;
            $item['paypal_raised_after_reset'] = str_contains($paypal_raised_after_reset, '-') ? 0 : $paypal_raised_after_reset;
            $paypal_withdraw = (float) PaypalPayout::where('compaign_id', $compaign->id)->sum('amount');
            $item['total_paypal_withdraw_after_reset'] = $paypal_withdraw - $item['total_paypal_withdraw_amount_at_reset'];
            $paypal_withdraw_limit = $item['paypal_raised_after_reset'] - $item['total_paypal_withdraw_after_reset'];
            $item['paypal_withdraw_limit'] = str_contains($paypal_withdraw_limit, '-') ? 0 : $paypal_withdraw_limit;

            // can user withdraw by disable/enable withdraw button
            $item['can_withdraw'] = $item['stripe_withdraw_limit'] > 0 || $item['paypal_withdraw_limit'] > 0;

            $starting = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->oldest()->first()?->created_at;

            $ending = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->latest()->first()?->created_at;

            $item['formatted_days'] = $this->days($starting, $ending);
            $item['formatted_dates'] = $this->dates($starting, $ending);
            $item['formatted_data'] = [];
            foreach ($item['formatted_dates'] as $date) {
                $item['formatted_data'][] = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->whereDate('created_at', $date)->sum('culacted');
            }
            $compaigns[] = $item;
            $formatted_compaigns['categories'][] = substr($compaign->name, 0, 10);
            $formatted_compaigns['stripe_donations'][] = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted');
            $formatted_compaigns['paypal_donations'][] = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('culacted');
        }

        // dd($compaigns);

        // getting data for stripe and paypal, getting formatted data for each compaign based on duration type
        $stripe_donations = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('type', DonationType::STRIPE->value)->sum('culacted');
        $paypal_donations = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('type', DonationType::PAYPAL->value)->sum('culacted');

        $total_stripe_withdraw = StripePayout::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->sum('amount');
        $total_paypal_withdraw = PaypalPayout::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->sum('amount');

        return view('dashboard', [
            'compaigns' => $compaigns,
            'formatted_compaigns' => $formatted_compaigns,
            'goal_amt' => Compaign::whereIn('id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->latest()->sum('goal_amt'),
            'total_raised' => Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->sum('culacted'),
            'total_withdraw' => (float) $total_stripe_withdraw + (float) $total_paypal_withdraw,
            'stripe_withdraw' => (float) $total_stripe_withdraw,
            'paypal_withdraw' => (float) $total_paypal_withdraw,
            'performance' => $performance,
            'stripe_donations' => $stripe_donations,
            'paypal_donations' => $paypal_donations,
            'stripe' => $stripe->balance(),
        ]);
    }
}
