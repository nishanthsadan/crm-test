@extends('layouts.app')

@section('title', 'Add Lead')
@section('page-title', 'Add New Lead')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('leads.store') }}" class="space-y-6">
            @csrf

            <!-- Basic Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Basic Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-300 @enderror">
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-300 @enderror">
                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text" name="company" value="{{ old('company') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Lead Details -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Lead Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority <span class="text-red-500">*</span></label>
                        <select name="priority" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                        <select name="source" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Source</option>
                            <option value="website">Website</option>
                            <option value="referral">Referral</option>
                            <option value="social_media">Social Media</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="trade_show">Trade Show</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected Value ($)</label>
                        <input type="number" name="expected_value" value="{{ old('expected_value') }}" min="0" step="0.01"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                        <select name="assigned_to" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Unassigned</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add notes about this lead...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    Create Lead
                </button>
                <a href="{{ route('leads.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
