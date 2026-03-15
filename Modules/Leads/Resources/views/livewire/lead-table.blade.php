<div>
    <!-- Filters Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 p-4">
        <div class="flex flex-wrap gap-3 items-center">
            <!-- Search -->
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search leads..."
                        class="pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                </div>
            </div>

            <!-- Status Filter -->
            <select wire:model.live="statusFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Statuses</option>
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="qualified">Qualified</option>
                <option value="lost">Lost</option>
                <option value="converted">Converted</option>
            </select>

            <!-- Priority Filter -->
            <select wire:model.live="priorityFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Priorities</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>

            <!-- Per page -->
            <select wire:model.live="perPage" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>

            <!-- Bulk Actions -->
            @if(count($selectedIds) > 0)
            <button wire:click="deleteSelected" wire:confirm="Delete {{ count($selectedIds) }} selected leads?"
                class="px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                Delete Selected ({{ count($selectedIds) }})
            </button>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left w-8">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('first_name')">
                            <div class="flex items-center space-x-1">
                                <span>Name</span>
                                @if($sortField === 'first_name')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('status')">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                @if($sortField === 'status')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('expected_value')">
                            <div class="flex items-center space-x-1">
                                <span>Value</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <input type="checkbox" value="{{ $lead->id }}" wire:model.live="selectedIds" class="rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-sm mr-3">
                                    {{ strtoupper(substr($lead->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('leads.show', $lead) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                        {{ $lead->full_name }}
                                    </a>
                                    @if($lead->email)
                                    <p class="text-xs text-gray-500">{{ $lead->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $lead->company ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {!! status_badge($lead->status) !!}
                        </td>
                        <td class="px-6 py-4">
                            {!! priority_badge($lead->priority) !!}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $lead->assignedTo?->name ?? 'Unassigned' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $lead->expected_value ? '$' . number_format($lead->expected_value, 0) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $lead->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('leads.show', $lead) }}" class="text-gray-400 hover:text-blue-600 transition" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('leads.edit', $lead) }}" class="text-gray-400 hover:text-blue-600 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button wire:click="deleteLead({{ $lead->id }})" wire:confirm="Delete this lead?" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">No leads found</p>
                            <a href="{{ route('leads.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                Add First Lead
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($leads->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

    <!-- Wire loading indicator -->
    <div wire:loading class="fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm">
        Loading...
    </div>
</div>
