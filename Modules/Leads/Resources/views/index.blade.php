@extends('layouts.app')

@section('title', 'Leads')
@section('page-title', 'Leads')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-500 text-sm">Manage and track your sales leads</p>
    </div>
    <a href="{{ route('leads.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Lead
    </a>
</div>

@livewire('leads.lead-table')
@endsection
