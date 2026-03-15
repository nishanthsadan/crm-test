<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 p-4">
        <div class="flex flex-wrap gap-3 items-center">
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search contacts..."
                        class="pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                </div>
            </div>
            <select wire:model.live="perPage" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
            @if(count($selectedIds) > 0)
            <button wire:click="deleteSelected" wire:confirm="Delete selected contacts?" class="px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">Delete Selected ({{ count($selectedIds) }})</button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left w-8"><input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300"></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('first_name')">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><input type="checkbox" value="{{ $contact->id }}" wire:model.live="selectedIds" class="rounded border-gray-300"></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-semibold text-sm mr-3">
                                {{ strtoupper(substr($contact->first_name, 0, 1)) }}
                            </div>
                            <a href="{{ route('contacts.show', $contact) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $contact->full_name }}</a>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contact->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contact->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contact->account?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contact->title ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('contacts.edit', $contact) }}" class="text-gray-400 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button wire:click="deleteContact({{ $contact->id }})" wire:confirm="Delete this contact?" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">No contacts found. <a href="{{ route('contacts.create') }}" class="text-blue-600 hover:underline">Add your first contact</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $contacts->links() }}</div>
        @endif
    </div>
</div>
