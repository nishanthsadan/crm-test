@extends('layouts.app')
@section('title', 'Edit Deal')
@section('page-title', 'Edit Deal')
@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('deals.update', $deal) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deal Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $deal->title) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stage</label>
                    <select name="stage" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(\Modules\Deals\Models\Deal::STAGES as $key => $info)
                        <option value="{{ $key }}" {{ old('stage', $deal->stage) == $key ? 'selected' : '' }}>{{ $info['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value ($)</label>
                    <input type="number" name="value" value="{{ old('value', $deal->value) }}" min="0" step="0.01" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Probability (%)</label>
                    <input type="number" name="probability" value="{{ old('probability', $deal->probability) }}" min="0" max="100" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expected Close Date</label>
                    <input type="date" name="expected_close_date" value="{{ old('expected_close_date', $deal->expected_close_date?->format('Y-m-d')) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                    <select name="assigned_to" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $deal->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $deal->description) }}</textarea>
                </div>
            </div>
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Save Changes</button>
                <a href="{{ route('deals.show', $deal) }}" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
