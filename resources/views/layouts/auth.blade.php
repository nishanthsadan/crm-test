<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRM') }} - @yield('title', 'Login')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    @livewireStyles
</head>
<body class="h-full bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 font-sans">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-white">CRM System</h2>
                <p class="mt-1 text-blue-200">Customer Relationship Management</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @yield('content')
            </div>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
