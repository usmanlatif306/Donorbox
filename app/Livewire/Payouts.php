<?php

namespace App\Livewire;

use App\Models\StripePayout;
use Livewire\Component;
use Livewire\WithPagination;

class Payouts extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";
    public string $payout_type = "all";

    public function render()
    {
        return view('livewire.payouts', [
            'payouts' => StripePayout::query()
                ->withoutGlobalScope('status')
                ->with(['compaign:id,name'])
                ->when($this->type !== "all", fn ($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn ($q) => $q->whereLike(['payout_id', 'amount', 'status', 'type'], $this->search)->orWhereHas('compaign', fn ($qry) => $qry->whereLike(['name'], $this->search)))
                ->when($this->payout_type !== "all", fn ($q) => $q->where('type', $this->payout_type))
                ->latest()
                ->paginate(),
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
