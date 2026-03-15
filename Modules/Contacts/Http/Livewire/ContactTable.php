<?php

namespace Modules\Contacts\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Contacts\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $selectedIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
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

    public function deleteContact(int $id): void
    {
        Contact::find($id)?->delete();
        session()->flash('success', 'Contact deleted.');
    }

    public function deleteSelected(): void
    {
        Contact::whereIn('id', $this->selectedIds)->delete();
        $this->selectedIds = [];
        session()->flash('success', 'Selected contacts deleted.');
    }

    public function render()
    {
        $query = Contact::with(['account', 'createdBy'])
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('first_name', 'like', "%{$this->search}%")
                          ->orWhere('last_name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%")
                          ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            $query->forUser(Auth::id());
        }

        $contacts = $query->paginate($this->perPage);
        return view('contacts::livewire.contact-table', compact('contacts'));
    }
}
