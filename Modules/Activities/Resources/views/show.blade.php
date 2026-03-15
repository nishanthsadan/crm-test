@extends('layouts.app')
@section('title', $activity->title)
@section('page-title', $activity->title)
@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-2">
        {!! status_badge($activity->status) !!}
        {!! priority_badge($activity->priority) !!}
    </div>
    <div class="flex items-center space-x-2">
        @if($activity->status !== 'completed')
        <form method="POST" action="{{ route('activities.complete', $activity) }}" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Mark Complete</button>
        </form>
        @endif
        <a href="{{ route('activities.edit', $activity) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Edit</a>
        <form method="POST" action="{{ route('activities.destroy', $activity) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this activity?')" class="px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">Delete</button>
        </form>
    </div>
</div>
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                @php $typeColors = ['call' => 'bg-green-100 text-green-700', 'meeting' => 'bg-blue-100 text-blue-700', 'task' => 'bg-yellow-100 text-yellow-700', 'email' => 'bg-purple-100 text-purple-700']; @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $typeColors[$activity->type] ?? 'bg-gray-100 text-gray-700' }} mr-3">
                    {{ ucfirst($activity->type) }}
                </span>
                <h3 class="text-lg font-semibold text-gray-900">{{ $activity->title }}</h3>
            </div>
            @if($activity->description)
            <p class="text-sm text-gray-700 mb-4">{{ $activity->description }}</p>
            @endif
        </div>
    </div>
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Details</h3>
            <div class="space-y-3">
                <div><p class="text-xs text-gray-500">Assigned To</p><p class="text-sm font-medium">{{ $activity->assignedTo?->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Due Date</p><p class="text-sm font-medium">{{ $activity->due_date?->format('M d, Y') ?? '-' }} {{ $activity->due_time ? 'at ' . $activity->due_time : '' }}</p></div>
                <div><p class="text-xs text-gray-500">Created By</p><p class="text-sm font-medium">{{ $activity->createdBy?->name }}</p></div>
                <div><p class="text-xs text-gray-500">Created</p><p class="text-sm font-medium">{{ $activity->created_at->format('M d, Y') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
