<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRM') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Livewire -->
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link.active { background-color: #1e40af; color: white; }
        .sidebar-link:hover:not(.active) { background-color: #1e3a8a; }
        body { margin: 0; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans" x-data="{ sidebarOpen: true }">

<div class="flex min-h-screen">

    <!-- ── Sidebar ────────────────────────────────────────────────── -->
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="bg-blue-900 text-white flex flex-col flex-shrink-0 transition-all duration-300 ease-in-out sticky top-0 h-screen overflow-y-auto">

        <!-- Logo / toggle -->
        <div class="flex items-center justify-between p-4 border-b border-blue-800 flex-shrink-0">
            <div x-show="sidebarOpen" x-cloak class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-blue-400 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="text-xl font-bold">CRM System</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded hover:bg-blue-800 ml-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-4">
            <div class="px-3 space-y-1">

                <a href="{{ route('dashboard') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Dashboard</span>
                </a>

                @if(module_enabled('Leads'))
                <a href="{{ route('leads.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('leads*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Leads</span>
                </a>
                @endif

                @if(module_enabled('Contacts'))
                <a href="{{ route('contacts.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('contacts*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Contacts</span>
                </a>
                @endif

                @if(module_enabled('Accounts'))
                <a href="{{ route('accounts.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('accounts*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Accounts</span>
                </a>
                @endif

                @if(module_enabled('Deals'))
                <a href="{{ route('deals.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('deals*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Deals</span>
                </a>
                @endif

                @if(module_enabled('Activities'))
                <a href="{{ route('activities.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('activities*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Activities</span>
                </a>
                @endif

                @if(module_enabled('Reports'))
                <a href="{{ route('reports.index') }}"
                   class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('reports*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Reports</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin() && module_enabled('Settings'))
                <div class="pt-4 mt-4 border-t border-blue-800">
                    <a href="{{ route('settings.index') }}"
                       class="sidebar-link flex items-center px-3 py-2 rounded-lg text-sm font-medium text-blue-100 {{ request()->routeIs('settings*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-cloak class="ml-3 whitespace-nowrap">Settings</span>
                    </a>
                </div>
                @endif

            </div>
        </nav>

        <!-- User info -->
        <div class="border-t border-blue-800 p-4 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <img class="w-8 h-8 rounded-full flex-shrink-0"
                     src="{{ auth()->user()->avatar_url }}"
                     alt="{{ auth()->user()->name }}">
                <div x-show="sidebarOpen" x-cloak class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-300 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ── Main area ──────────────────────────────────────────────── -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-20">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('breadcrumbs')
                    <nav class="flex mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm text-gray-500">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                    @endif
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900">
                            <img class="w-8 h-8 rounded-full"
                                 src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}">
                            <span class="font-medium hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open"
                             x-cloak
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="py-1">
                                <a href="{{ route('settings.profile') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                   Profile Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">

            <!-- Flash: success -->
            @if(session('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Flash: error -->
            @if(session('error'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

@livewireScripts
@stack('scripts')
</body>
</html>
