<?php

namespace App\Livewire;

use App\Models\Compaign;
use Livewire\Component;
use Livewire\WithPagination;

class Compaigns extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";

    public function render()
    {
        return view('livewire.compaigns', [
            'compaigns' => Compaign::query()
                ->withSum('stripe_payouts', 'amount')
                ->when($this->type !== "all", fn ($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn ($q) => $q->whereLike(['name'], $this->search))
                ->latest()
                ->paginate(),
        ]);
    }

    public function changeType(string $type)
    {
        $this->type = $type;
    }

    public function toggleShow(Compaign $compaign)
    {
        $compaign->update(['show' => !$compaign->show]);
    }
    // 504654,511286,511287,511291,511292
}
