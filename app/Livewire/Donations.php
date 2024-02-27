<?php

namespace App\Livewire;

use App\Models\Donation;
use Livewire\Component;
use Livewire\WithPagination;

class Donations extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";
    public string $donation_type = "all";
    public string $currency_sign = "";

    public function mount()
    {
        $this->currency_sign = currency_sign();
    }

    public function render()
    {
        return view('livewire.donations', [
            'donations' => Donation::query()
                ->with(['compaign:id,name', 'donor'])
                ->when($this->type !== "all", fn ($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn ($q) => $q->whereLike(['type'], $this->search)->orWhereHas('donor', fn ($qry) => $qry->whereLike(['first_name', 'last_name', 'email'], $this->search))->orWhereHas('compaign', fn ($qry) => $qry->whereLike(['name'], $this->search)))
                ->when($this->donation_type !== "all", fn ($q) => $q->where('type', $this->donation_type))
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
