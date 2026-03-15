@extends('layouts.app')
@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-500 text-sm">Manage user accounts and roles</p>
    </div>
    <a href="{{ route('settings.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add User
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <img class="w-8 h-8 rounded-full mr-3" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $roleColors = ['admin' => 'bg-red-100 text-red-800', 'manager' => 'bg-blue-100 text-blue-800', 'user' => 'bg-gray-100 text-gray-800'];
                        $roleColor = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->phone ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->status === 'active')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('settings.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('settings.users.destroy', $user) }}"
                              onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
