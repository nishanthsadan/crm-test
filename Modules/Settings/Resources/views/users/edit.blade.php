@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center space-x-3 mb-6 pb-6 border-b border-gray-100">
            <img class="w-10 h-10 rounded-full" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            <div>
                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.users.update', $user) }}" class="space-y-5">
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

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Change Password <span class="text-xs text-gray-400 font-normal">(leave blank to keep current)</span></h4>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" minlength="8"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-300 @enderror">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" minlength="8"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('settings.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
