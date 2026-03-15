@extends('layouts.app')
@section('title', 'Edit Account')
@section('page-title', 'Edit: ' . $account->name)
@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('accounts.update', $account) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $account->name) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $account->email) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $account->phone) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url" name="website" value="{{ old('website', $account->website) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <select name="industry" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Industry</option>
                        @foreach(['technology', 'finance', 'healthcare', 'retail', 'manufacturing', 'education', 'real_estate', 'consulting', 'media', 'other'] as $ind)
                        <option value="{{ $ind }}" {{ old('industry', $account->industry) == $ind ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $ind)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Employees</label>
                    <input type="number" name="employees_count" value="{{ old('employees_count', $account->employees_count) }}" min="0" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Annual Revenue ($)</label>
                    <input type="number" name="annual_revenue" value="{{ old('annual_revenue', $account->annual_revenue) }}" min="0" step="0.01" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $account->city) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" name="country" value="{{ old('country', $account->country) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $account->description) }}</textarea>
                </div>
            </div>
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Save Changes</button>
                <a href="{{ route('accounts.show', $account) }}" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
