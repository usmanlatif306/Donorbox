<?php

namespace App\Http\Controllers;

use App\Enums\DonationType;
use App\Models\Compaign;
use App\Models\Donation;
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
        foreach (Compaign::withSum('stripe_payouts', 'amount', 'culacted')->whereIn('id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->latest()->get() as $idx => $compaign) {
            $item['colour']  = $colours[$idx];
            unset($colours[$idx]);
            $item['compaign']  = $compaign;
            $item['id']  = $compaign->id;

            $item['total_raised']  = Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            $item['total_raised_with_tax']  = Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('culacted');
            $item['total_withdraw']  = StripePayout::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->sum('amount');
            $item['remaining_balance'] = (float)$item['total_raised'] - (float)$item['total_withdraw'];

            $item['withdraw_limit']  = (float)Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted') - (float)StripePayout::where('compaign_id', $compaign->id)->sum('amount');

            $starting = Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->oldest()->first()?->created_at;

            $ending = Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->latest()->first()?->created_at;

            $item['formatted_days'] = $this->days($starting, $ending);
            $item['formatted_dates'] = $this->dates($starting, $ending);
            $item['formatted_data'] = [];
            foreach ($item['formatted_dates'] as $date) {
                $item['formatted_data'][] = Donation::when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->whereDate('created_at', $date)->sum('culacted');
            }
            $compaigns[] =  $item;
            $formatted_compaigns['categories'][] =  substr($compaign->name, 0, 10);
            $formatted_compaigns['stripe_donations'][] =  Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::STRIPE->value)->sum('culacted');
            $formatted_compaigns['paypal_donations'][] =  Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('compaign_id', $compaign->id)->where('type', DonationType::PAYPAL->value)->sum('culacted');
        }

        // getting data for stripe and paypal, getting formatted data for each compaign based on duration type
        $stripe_donations = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('type', DonationType::STRIPE->value)->sum('culacted');
        $paypal_donations = Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->where('type', DonationType::PAYPAL->value)->sum('culacted');

        return view('dashboard', [
            'compaigns' => $compaigns,
            'formatted_compaigns' => $formatted_compaigns,
            'goal_amt' => Compaign::whereIn('id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->latest()->sum('goal_amt'),
            'total_raised' => Donation::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->sum('culacted'),
            'total_withdraw' => StripePayout::whereIn('compaign_id', active_compaigns())->when($request->has('type') && $request->type !== 'all', fn ($q) => $q->duration($request->type))->sum('amount'),
            'performance' => $performance,
            'stripe_donations' => $stripe_donations,
            'paypal_donations' => $paypal_donations,
            'stripe' => $stripe->balance(),
        ]);
    }
}
