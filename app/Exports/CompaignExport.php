<?php

namespace App\Exports;

use App\Models\Compaign;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompaignExport implements FromView
{
    public function view(): View
    {
        return view('exports.compaigns', [
            'compaigns' => Compaign::find(active_compaigns()),
            'currency_sign' => currency_sign()
        ]);
    }
}
