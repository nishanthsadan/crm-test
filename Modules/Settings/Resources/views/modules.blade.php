@extends('layouts.app')
@section('title', 'Module Management')
@section('page-title', 'Module Management')

@section('content')
<div class="mb-6">
    <p class="text-gray-500 text-sm">Enable or disable CRM modules. Core modules cannot be disabled.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($moduleStatuses as $module => $info)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-1">
                    <h3 class="text-sm font-semibold text-gray-900">{{ $info['name'] }}</h3>
                    @if($info['core'])
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">Core</span>
                    @endif
                </div>
                @php
                    $descriptions = [
                        'Core'       => 'Framework foundation and helpers',
                        'Auth'       => 'Authentication and session management',
                        'Dashboard'  => 'Overview charts and key metrics',
                        'Leads'      => 'Capture and manage sales leads',
                        'Contacts'   => 'Contact persons and communication',
                        'Accounts'   => 'Company and organisation records',
                        'Deals'      => 'Sales pipeline and deal tracking',
                        'Activities' => 'Tasks, calls, meetings and emails',
                        'Reports'    => 'Analytics and data exports',
                        'Settings'   => 'Users, roles and system config',
                    ];
                @endphp
                <p class="text-xs text-gray-500">{{ $descriptions[$module] ?? '' }}</p>
            </div>

            <div class="ml-4 flex-shrink-0">
                @if($info['core'])
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Always On
                    </span>
                @else
                    <form method="POST" action="{{ route('settings.modules.toggle', $module) }}">
                        @csrf
                        <button type="submit"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $info['enabled'] ? 'bg-blue-600' : 'bg-gray-300' }}"
                            title="{{ $info['enabled'] ? 'Click to disable' : 'Click to enable' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $info['enabled'] ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mt-3 pt-3 border-t border-gray-100">
            @if($info['enabled'])
                <span class="text-xs text-green-600 font-medium">Enabled</span>
            @else
                <span class="text-xs text-gray-400 font-medium">Disabled</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
