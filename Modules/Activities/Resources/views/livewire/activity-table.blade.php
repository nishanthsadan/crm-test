<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 p-4">
        <div class="flex flex-wrap gap-3 items-center">
            <div class="flex-1 min-w-48 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search activities..."
                    class="pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
            </div>
            <select wire:model.live="typeFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                <option value="call">Call</option>
                <option value="meeting">Meeting</option>
                <option value="task">Task</option>
                <option value="email">Email</option>
            </select>
            <select wire:model.live="statusFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('title')">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer" wire:click="sortBy('due_date')">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                <tr class="hover:bg-gray-50 {{ $activity->status === 'completed' ? 'opacity-60' : '' }}">
                    <td class="px-6 py-4">
                        @php
                            $typeColors = ['call' => 'bg-green-100 text-green-700', 'meeting' => 'bg-blue-100 text-blue-700', 'task' => 'bg-yellow-100 text-yellow-700', 'email' => 'bg-purple-100 text-purple-700'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColors[$activity->type] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($activity->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('activities.show', $activity) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 {{ $activity->status === 'completed' ? 'line-through' : '' }}">{{ $activity->title }}</a>
                    </td>
                    <td class="px-6 py-4">{!! status_badge($activity->status) !!}</td>
                    <td class="px-6 py-4">{!! priority_badge($activity->priority) !!}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if($activity->due_date)
                            <span class="{{ $activity->due_date->isPast() && $activity->status !== 'completed' ? 'text-red-600 font-medium' : '' }}">
                                {{ $activity->due_date->format('M d, Y') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $activity->assignedTo?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            @if($activity->status !== 'completed')
                            <button wire:click="completeActivity({{ $activity->id }})" class="text-gray-400 hover:text-green-600 transition" title="Mark complete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                            @endif
                            <a href="{{ route('activities.edit', $activity) }}" class="text-gray-400 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button wire:click="deleteActivity({{ $activity->id }})" wire:confirm="Delete this activity?" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-sm">
                        No activities found. <a href="{{ route('activities.create') }}" class="text-blue-600 hover:underline">Log your first activity</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($activities->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $activities->links() }}</div>
        @endif
    </div>
</div>
