@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')
@section('content')

<!-- Summary Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-blue-600">{{ number_format($data['total_leads']) }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Leads</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-purple-600">{{ number_format($data['total_contacts']) }}</p>
        <p class="text-xs text-gray-500 mt-1">Contacts</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-indigo-600">{{ number_format($data['total_deals']) }}</p>
        <p class="text-xs text-gray-500 mt-1">Deals</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-orange-600">${{ number_format($data['pipeline_value'], 0) }}</p>
        <p class="text-xs text-gray-500 mt-1">Pipeline Value</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-green-600">${{ number_format($data['won_value'], 0) }}</p>
        <p class="text-xs text-gray-500 mt-1">Won Revenue</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-yellow-600">{{ number_format($data['open_activities']) }}</p>
        <p class="text-xs text-gray-500 mt-1">Open Activities</p>
    </div>
</div>

<!-- Report Links -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('reports.leads') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-blue-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Leads Report</h3>
                <p class="text-sm text-gray-500">Status, source & priority breakdown</p>
            </div>
        </div>
    </a>

    <a href="{{ route('reports.deals') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-green-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Deals Report</h3>
                <p class="text-sm text-gray-500">Pipeline stages & revenue</p>
            </div>
        </div>
    </a>

    <a href="{{ route('reports.activities') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-yellow-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 rounded-lg group-hover:bg-yellow-200 transition">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Activities Report</h3>
                <p class="text-sm text-gray-500">Task completion & activity types</p>
            </div>
        </div>
    </a>
</div>

<!-- Export Section -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Export Data</h3>
    <div class="flex space-x-4">
        <a href="{{ route('reports.export.leads') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Leads (CSV)
        </a>
        <a href="{{ route('reports.export.deals') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Deals (CSV)
        </a>
    </div>
</div>
@endsection
