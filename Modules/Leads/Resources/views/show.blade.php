@extends('layouts.app')

@section('title', $lead->full_name)
@section('page-title', $lead->full_name)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        {!! status_badge($lead->status) !!}
        {!! priority_badge($lead->priority) !!}
    </div>
    <div class="flex items-center space-x-2">
        @if($lead->status !== 'converted')
        <form method="POST" action="{{ route('leads.convert', $lead) }}" class="inline">
            @csrf
            <button type="submit" onclick="return confirm('Convert this lead to a contact?')"
                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                Convert to Contact
            </button>
        </form>
        @endif
        <a href="{{ route('leads.edit', $lead) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            Edit Lead
        </a>
        <form method="POST" action="{{ route('leads.destroy', $lead) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this lead?')"
                class="px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">
                Delete
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Contact Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Full Name</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->full_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Company</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->company ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Email</p>
                    <p class="text-sm font-medium text-gray-900">
                        @if($lead->email)
                        <a href="mailto:{{ $lead->email }}" class="text-blue-600 hover:underline">{{ $lead->email }}</a>
                        @else -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Phone</p>
                    <p class="text-sm font-medium text-gray-900">
                        @if($lead->phone)
                        <a href="tel:{{ $lead->phone }}" class="text-blue-600 hover:underline">{{ $lead->phone }}</a>
                        @else -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Source</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->source ? ucwords(str_replace('_', ' ', $lead->source)) : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Expected Value</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->expected_value ? '$' . number_format($lead->expected_value, 2) : '-' }}</p>
                </div>
            </div>

            @if($lead->description)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2">Description</p>
                <p class="text-sm text-gray-700">{{ $lead->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Details</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Assigned To</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->assignedTo?->name ?? 'Unassigned' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Created By</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->createdBy?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Created At</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Last Updated</p>
                    <p class="text-sm font-medium text-gray-900">{{ $lead->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Quick Actions</h3>
            </div>
            <div class="space-y-2">
                <a href="{{ route('activities.create') }}?actable_type=lead&actable_id={{ $lead->id }}"
                    class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Log Activity
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
