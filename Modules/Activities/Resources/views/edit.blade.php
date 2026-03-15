@extends('layouts.app')
@section('title', 'Edit Activity')
@section('page-title', 'Edit Activity')
@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('activities.update', $activity) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['task', 'call', 'meeting', 'email'] as $type)
                        <option value="{{ $type }}" {{ old('type', $activity->type) === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['low', 'medium', 'high'] as $priority)
                        <option value="{{ $priority }}" {{ old('priority', $activity->priority) === $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $activity->title) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ old('status', $activity->status) === $status ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                    <select name="assigned_to" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $activity->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $activity->due_date?->format('Y-m-d')) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due Time</label>
                    <input type="time" name="due_time" value="{{ old('due_time', $activity->due_time) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $activity->description) }}</textarea>
                </div>
            </div>
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Save Changes</button>
                <a href="{{ route('activities.show', $activity) }}" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
