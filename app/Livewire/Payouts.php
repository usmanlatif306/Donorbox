<?php

namespace App\Livewire;

use App\Models\PaypalPayout;
use App\Models\StripePayout;
use Livewire\Component;
use Livewire\WithPagination;

class Payouts extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";
    public string $payout_type = "stripe";

    public function render()
    {
        return view('livewire.payouts', [
            'payouts' => $this->payout_type === "stripe" ? StripePayout::query()
                ->withoutGlobalScope('status')
                ->with(['compaign:id,name'])
                ->when($this->type !== "all", fn($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn($q) => $q->whereLike(['payout_id', 'amount', 'status', 'type'], $this->search)->orWhereHas('compaign', fn($qry) => $qry->whereLike(['name'], $this->search)))
                ->latest()
                ->paginate() :
                PaypalPayout::query()
                    ->withoutGlobalScope('status')
                    ->with(['compaign:id,name'])
                    ->when($this->type !== "all", fn($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                    ->when($this->search, fn($q) => $q->whereLike(['payout_id', 'amount', 'status'], $this->search)->orWhereHas('compaign', fn($qry) => $qry->whereLike(['name'], $this->search)))
                    ->latest()
                    ->paginate()
            ,
        ]);
    }

    public function changeType(string $type)
    {
        $this->resetPage();
        $this->type = $type;
    }

    public function changePayoutType(string $type)
    {
        $this->resetPage();
        $this->payout_type = $type;
    }
}
