@extends('layouts.app')
@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Users</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['active_users'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Active Users</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_modules'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Modules</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-3xl font-bold text-indigo-600">{{ $stats['enabled_modules'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Enabled Modules</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('settings.users.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-blue-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">User Management</h3>
                <p class="text-sm text-gray-500">Manage users, roles and permissions</p>
            </div>
        </div>
    </a>

    <a href="{{ route('settings.modules') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-purple-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Module Management</h3>
                <p class="text-sm text-gray-500">Enable or disable CRM modules</p>
            </div>
        </div>
    </a>

    <a href="{{ route('settings.profile') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition hover:border-green-300 group">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">My Profile</h3>
                <p class="text-sm text-gray-500">Update your profile and password</p>
            </div>
        </div>
    </a>
</div>
@endsection
