<?php

namespace Modules\Activities\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activities\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = '';
    public string $statusFilter = '';
    public string $sortField = 'due_date';
    public string $sortDirection = 'asc';
    public int $perPage = 25;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedTypeFilter(): void { $this->resetPage(); }
    public function updatedStatusFilter(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteActivity(int $id): void
    {
        Activity::find($id)?->delete();
        session()->flash('success', 'Activity deleted.');
    }

    public function completeActivity(int $id): void
    {
        Activity::find($id)?->update(['status' => 'completed']);
        session()->flash('success', 'Activity marked as completed.');
    }

    public function render()
    {
        $query = Activity::with(['assignedTo'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortField, $this->sortDirection);

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            $query->forUser(Auth::id());
        }

        $activities = $query->paginate($this->perPage);
        return view('activities::livewire.activity-table', compact('activities'));
    }
}
