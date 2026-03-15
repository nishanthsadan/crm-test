<?php

namespace Modules\Deals\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Deals\Models\Deal;
use Illuminate\Support\Facades\Auth;

class DealTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $stageFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $selectedIds = [];

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStageFilter(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteDeal(int $id): void
    {
        Deal::find($id)?->delete();
        session()->flash('success', 'Deal deleted.');
    }

    public function render()
    {
        $query = Deal::with(['account', 'assignedTo'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->stageFilter, fn ($q) => $q->where('stage', $this->stageFilter))
            ->orderBy($this->sortField, $this->sortDirection);

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            $query->forUser(Auth::id());
        }

        $deals = $query->paginate($this->perPage);
        return view('deals::livewire.deal-table', compact('deals'));
    }
}
