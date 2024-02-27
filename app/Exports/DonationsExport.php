<?php

namespace App\Exports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DonationsExport implements FromView
{
    public function view(): View
    {
        return view('exports.donations', [
            'donations' => Donation::with(['compaign:id,name', 'donor:id,first_name,last_name,email'])->whereIn('compaign_id', active_compaigns())->get(),
            'currency_sign' => currency_sign()
        ]);
    }
}
