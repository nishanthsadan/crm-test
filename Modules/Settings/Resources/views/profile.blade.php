@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Profile Information --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center space-x-4 mb-6">
            <img class="w-16 h-16 rounded-full" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 capitalize">{{ $user->role }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-300 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-300 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-900 mb-4">Change Password</h3>

        <form method="POST" action="{{ route('settings.profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-300 @enderror">
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required minlength="8"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-300 @enderror">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required minlength="8"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                    Change Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
