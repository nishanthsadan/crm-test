@extends('layouts.app')
@section('title', $account->name)
@section('page-title', $account->name)
@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="text-sm text-gray-500">{{ $account->industry ? ucwords(str_replace('_', ' ', $account->industry)) : '' }}</div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('accounts.edit', $account) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Edit Account</a>
        <form method="POST" action="{{ route('accounts.destroy', $account) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this account?')" class="px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">Delete</button>
        </form>
    </div>
</div>
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Company Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500">Email</p><p class="text-sm font-medium">{{ $account->email ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Phone</p><p class="text-sm font-medium">{{ $account->phone ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Website</p><p class="text-sm font-medium">{{ $account->website ? '<a href="'.$account->website.'" target="_blank" class="text-blue-600">'.$account->website.'</a>' : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Industry</p><p class="text-sm font-medium">{{ $account->industry ? ucwords(str_replace('_', ' ', $account->industry)) : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Employees</p><p class="text-sm font-medium">{{ $account->employees_count ? number_format($account->employees_count) : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Annual Revenue</p><p class="text-sm font-medium">{{ $account->annual_revenue ? '$'.number_format($account->annual_revenue, 0) : '-' }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-500">Location</p><p class="text-sm font-medium">{{ $account->location ?: '-' }}</p></div>
            </div>
            @if($account->description)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2">Description</p>
                <p class="text-sm text-gray-700">{{ $account->description }}</p>
            </div>
            @endif
        </div>

        <!-- Contacts Tab -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Contacts ({{ $account->contacts->count() }})</h3>
                <a href="{{ route('contacts.create') }}?account_id={{ $account->id }}" class="text-sm text-blue-600 hover:text-blue-700">+ Add Contact</a>
            </div>
            @forelse($account->contacts->take(5) as $contact)
            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                <div class="flex items-center space-x-3">
                    <div class="w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xs font-semibold">{{ strtoupper(substr($contact->first_name, 0, 1)) }}</div>
                    <div>
                        <a href="{{ route('contacts.show', $contact) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $contact->full_name }}</a>
                        <p class="text-xs text-gray-500">{{ $contact->title ?? $contact->email }}</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">No contacts linked to this account</p>
            @endforelse
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Summary</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Contacts</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $account->contacts->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Deals</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $account->deals->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Created By</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $account->createdBy?->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Created</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $account->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
