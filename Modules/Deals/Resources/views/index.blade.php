@extends('layouts.app')
@section('title', 'Deals')
@section('page-title', 'Deals')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('deals.index') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg">List View</a>
        <a href="{{ route('deals.pipeline') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Pipeline View</a>
    </div>
    <a href="{{ route('deals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Deal
    </a>
</div>
@livewire('deals.deal-table')
@endsection
