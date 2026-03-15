@extends('layouts.app')
@section('title', $deal->title)
@section('page-title', $deal->title)
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>{!! status_badge($deal->stage) !!}</div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('deals.edit', $deal) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Edit Deal</a>
        <form method="POST" action="{{ route('deals.destroy', $deal) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this deal?')" class="px-4 py-2 border border-red-300 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">Delete</button>
        </form>
    </div>
</div>
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Deal Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-xs text-gray-500">Account</p><p class="text-sm font-medium">{{ $deal->account?->name ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Contact</p><p class="text-sm font-medium">{{ $deal->contact ? $deal->contact->first_name.' '.$deal->contact->last_name : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Value</p><p class="text-sm font-semibold text-green-600">{{ $deal->value ? '$'.number_format($deal->value, 2) : '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Probability</p><p class="text-sm font-medium">{{ $deal->probability }}%</p></div>
                <div><p class="text-xs text-gray-500">Expected Close</p><p class="text-sm font-medium">{{ $deal->expected_close_date?->format('M d, Y') ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-500">Assigned To</p><p class="text-sm font-medium">{{ $deal->assignedTo?->name ?? 'Unassigned' }}</p></div>
            </div>
            @if($deal->description)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-2">Description</p>
                <p class="text-sm text-gray-700">{{ $deal->description }}</p>
            </div>
            @endif
        </div>
    </div>
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Stage Progress</h3>
            <div class="space-y-2">
                @foreach(\Modules\Deals\Models\Deal::STAGES as $key => $info)
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full {{ $deal->stage === $key ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    <span class="text-sm {{ $deal->stage === $key ? 'font-semibold text-gray-900' : 'text-gray-500' }}">{{ $info['label'] }}</span>
                    @if($deal->stage === $key)<span class="ml-auto text-xs text-blue-600">Current</span>@endif
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">Created By</p>
                <p class="text-sm font-medium">{{ $deal->createdBy?->name }}</p>
                <p class="text-xs text-gray-500 mt-2">Created</p>
                <p class="text-sm font-medium">{{ $deal->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
