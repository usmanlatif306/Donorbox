<?php

namespace App\Livewire;

use App\Models\Donor;
use Livewire\Component;
use Livewire\WithPagination;

class Donors extends Component
{
    use WithPagination;

    public string $search = "";
    public string $type = "all";

    public function render()
    {
        return view('livewire.donors', [
            'donors' => Donor::query()
                ->when($this->type !== "all", fn ($q) => $this->type === 'week' ? $q->week() : ($this->type === 'month' ? $q->month() : ""))
                ->when($this->search, fn ($q) => $q->whereLike(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zip_code', 'country'], $this->search))
                ->latest()
                ->paginate(),
        ]);
    }


    public function changeType(string $type)
    {
        $this->type = $type;
    }
}
