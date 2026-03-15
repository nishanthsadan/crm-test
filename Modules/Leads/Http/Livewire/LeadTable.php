<?php

namespace Modules\Leads\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Leads\Models\Lead;
use Illuminate\Support\Facades\Auth;

class LeadTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $priorityFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $selectedIds = [];
    public bool $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteSelected(): void
    {
        Lead::whereIn('id', $this->selectedIds)->delete();
        $this->selectedIds = [];
        $this->selectAll = false;
        session()->flash('success', 'Selected leads deleted.');
    }

    public function deleteLead(int $id): void
    {
        Lead::find($id)?->delete();
        session()->flash('success', 'Lead deleted.');
    }

    public function render()
    {
        $query = Lead::with(['assignedTo'])
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%")
                          ->orWhere('company', 'like', "%{$this->search}%")
                          ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn ($q) => $q->where('priority', $this->priorityFilter))
            ->orderBy($this->sortField, $this->sortDirection);

        // If not admin/manager, only show own leads
        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            $query->forUser(Auth::id());
        }

        $leads = $query->paginate($this->perPage);

        return view('leads::livewire.lead-table', compact('leads'));
    }
}
