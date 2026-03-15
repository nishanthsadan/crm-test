@extends('layouts.app')
@section('title', $contact->full_name)
@section('page-title', $contact->full_name)
@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('contacts.edit', $contact) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Edit Contact</a>
        <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this contact?')" class="px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">Delete</button>
        </form>
    </div>
</div>
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Contact Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500 mb-1">Full Name</p><p class="text-sm font-medium">{{ $contact->full_name }}</p></div>
                <div><p class="text-xs text-gray-500 mb-1">Job Title</p><p class="text-sm font-medium">{{ $contact->title ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 mb-1">Email</p><p class="text-sm font-medium">{{ $contact->email ? '<a href="mailto:'.$contact->email.'" class="text-blue-600">'.$contact->email.'</a>' : '-' }}</p></div>
                <div><p class="text-xs text-gray-500 mb-1">Phone</p><p class="text-sm font-medium">{{ $contact->phone ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 mb-1">Department</p><p class="text-sm font-medium">{{ $contact->department ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500 mb-1">Account</p><p class="text-sm font-medium">{{ $contact->account?->name ?? '-' }}</p></div>
            </div>
            @if($contact->description)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2">Description</p>
                <p class="text-sm text-gray-700">{{ $contact->description }}</p>
            </div>
            @endif
        </div>
    </div>
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Details</h3>
            <div class="space-y-3">
                <div><p class="text-xs text-gray-500">Source</p><p class="text-sm font-medium">{{ $contact->source ? ucwords(str_replace('_', ' ', $contact->source)) : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Created By</p><p class="text-sm font-medium">{{ $contact->createdBy?->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Created At</p><p class="text-sm font-medium">{{ $contact->created_at->format('M d, Y') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
