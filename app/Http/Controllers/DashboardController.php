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

            $total_raised = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            $total_raised_after_reset = $compaign->reset?->last_total ?? 0;
            $item['total_raised'] = $total_raised - $total_raised_after_reset;

            $total_raised_with_tax = Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('culacted');
            $total_raised_with_tax_after_reset = $compaign->reset?->last_total_with_tax ?? 0;
            $item['total_raised_with_tax'] = $total_raised_with_tax - $total_raised_with_tax_after_reset;

            $item['stripe_withdraw'] = StripePayout::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            $item['paypal_withdraw'] = PaypalPayout::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            // $item['total_withdraw'] = StripePayout::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            $item['total_withdraw'] = $item['stripe_withdraw'] + $item['paypal_withdraw'];
            $item['remaining_balance'] = (float) $item['total_raised'] - (float) $item['total_withdraw'];

            // calculating stripe remaining withdraw limit
            $stripe_calculated = (float) Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted');
            $calculated_after_reset = $stripe_calculated - $total_raised_with_tax_after_reset;
            $item['stripe_withdraw'] = (float) StripePayout::where('compaign_id', $compaign->id)->sum('amount');
            $item['stripe_withdraw_limit'] = $calculated_after_reset - $item['stripe_withdraw'];

            // calculating paypal remaining withdraw limit
            $paypal_calculated = (float) Donation::when($request->has('type') && $request->type !== 'all', fn($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('culacted');
            $paypal_calculated_after_reset = $paypal_calculated - $total_raised_with_tax_after_reset;
            $item['paypal_withdraw'] = (float) PaypalPayout::where('compaign_id', $compaign->id)->sum('amount');
            $item['paypal_withdraw_limit'] = $paypal_calculated_after_reset - $item['paypal_withdraw'];

            // can user withdraw by disable/enable withdraw button
            // $item['can_withdraw'] = $calculated_after_reset > $item['stripe_withdraw_limit'] || $calculated_after_reset > $item['paypal_withdraw_limit'];
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
