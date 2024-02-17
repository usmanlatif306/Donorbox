<?php

namespace App\Livewire;

use App\Models\Plan;
use Livewire\Component;
use Livewire\WithPagination;

class Plans extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";
    public string $donation_type = "all";

    public function render()
    {
        return view('livewire.plans', [
            'plans' => Plan::query()
                ->with(['compaign:id,name', 'donor'])
                ->when($this->type !== "all", fn ($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn ($q) => $q->whereLike(['type', 'payment_method'], $this->search)->orWhereHas('donor', fn ($qry) => $qry->whereLike(['first_name', 'last_name', 'email'], $this->search))->orWhereHas('compaign', fn ($qry) => $qry->whereLike(['name'], $this->search)))
                ->when($this->donation_type !== "all", fn ($q) => $q->where('payment_method', $this->donation_type))
                ->latest()
                ->paginate(),
        ]);
    }

    public function changeType(string $type)
    {
        $this->resetPage();
        $this->type = $type;
    }

    public function changeDonationType(string $type)
    {
        $this->resetPage();
        $this->donation_type = $type;
    }
}
