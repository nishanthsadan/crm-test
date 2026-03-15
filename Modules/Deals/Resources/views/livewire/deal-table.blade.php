<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 p-4">
        <div class="flex flex-wrap gap-3 items-center">
            <div class="flex-1 min-w-48 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search deals..."
                    class="pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
            </div>
            <select wire:model.live="stageFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Stages</option>
                <option value="prospect">Prospect</option>
                <option value="proposal">Proposal</option>
                <option value="negotiation">Negotiation</option>
                <option value="won">Won</option>
                <option value="lost">Lost</option>
            </select>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('title')">Deal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('stage')">Stage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('value')">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Probability</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Close Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($deals as $deal)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="{{ route('deals.show', $deal) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $deal->title }}</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $deal->account?->name ?? '-' }}</td>
                    <td class="px-6 py-4">{!! status_badge($deal->stage) !!}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $deal->value ? '$'.number_format($deal->value, 0) : '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-1.5 w-16">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $deal->probability }}%"></div>
                            </div>
                            <span class="text-xs text-gray-600">{{ $deal->probability }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $deal->expected_close_date?->format('M d, Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $deal->assignedTo?->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('deals.edit', $deal) }}" class="text-gray-400 hover:text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button wire:click="deleteDeal({{ $deal->id }})" wire:confirm="Delete this deal?" class="text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500 text-sm">
                        No deals found. <a href="{{ route('deals.create') }}" class="text-blue-600 hover:underline">Add your first deal</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($deals->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $deals->links() }}</div>
        @endif
    </div>
</div>
