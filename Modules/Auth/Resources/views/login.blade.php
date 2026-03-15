@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div>
    <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome back</h3>
    <p class="text-gray-600 mb-6">Sign in to your CRM account</p>

    @if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
        @foreach ($errors->all() as $error)
            <p class="text-sm">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input id="email" name="email" type="email" autocomplete="email" required
                value="{{ old('email') }}"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-300 @enderror"
                placeholder="admin@crm.com">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-300 @enderror"
                placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
            Sign In
        </button>
    </form>

    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
        <p class="text-xs text-blue-700 font-medium mb-2">Demo Credentials:</p>
        <div class="space-y-1 text-xs text-blue-600">
            <p>Admin: admin@crm.com / password</p>
            <p>Manager: manager@crm.com / password</p>
            <p>User: user@crm.com / password</p>
        </div>
    </div>
</div>
@endsection
