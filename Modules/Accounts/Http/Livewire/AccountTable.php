<?php

namespace Modules\Accounts\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Accounts\Models\Account;

class AccountTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $selectedIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSearch(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteAccount(int $id): void
    {
        Account::find($id)?->delete();
        session()->flash('success', 'Account deleted.');
    }

    public function render()
    {
        $accounts = Account::withCount(['contacts', 'deals'])
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%")
                          ->orWhere('industry', 'like', "%{$this->search}%")
                          ->orWhere('city', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('accounts::livewire.account-table', compact('accounts'));
    }
}
