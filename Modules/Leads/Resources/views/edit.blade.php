@extends('layouts.app')

@section('title', 'Edit Lead')
@section('page-title', 'Edit Lead: ' . $lead->full_name)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('leads.update', $lead) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Basic Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $lead->first_name) }}" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $lead->last_name) }}" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $lead->email) }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $lead->phone) }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text" name="company" value="{{ old('company', $lead->company) }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Lead Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach(['new', 'contacted', 'qualified', 'lost', 'converted'] as $status)
                            <option value="{{ $status }}" {{ old('status', $lead->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach(['low', 'medium', 'high'] as $priority)
                            <option value="{{ $priority }}" {{ old('priority', $lead->priority) == $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                        <select name="source" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Source</option>
                            @foreach(['website', 'referral', 'social_media', 'email', 'phone', 'trade_show', 'other'] as $source)
                            <option value="{{ $source }}" {{ old('source', $lead->source) == $source ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $source)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected Value ($)</label>
                        <input type="number" name="expected_value" value="{{ old('expected_value', $lead->expected_value) }}" min="0" step="0.01"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                        <select name="assigned_to" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Unassigned</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $lead->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    Save Changes
                </button>
                <a href="{{ route('leads.show', $lead) }}" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
