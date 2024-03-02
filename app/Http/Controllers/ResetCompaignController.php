<?php

namespace App\Http\Controllers;

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
        $total_raised = Donation::where('compaign_id', $compaign->id)->sum('amount');
        $total_raised_with_tax = Donation::where('compaign_id', $compaign->id)->sum('culacted');

        $compaign->resets()->create([
            'last_total' => $total_raised,
            'last_total_with_tax' => $total_raised_with_tax,
        ]);

        return back()->with('success', 'Campaign Reset Successfully!');
    }
}
