@extends('layouts.app')
@section('title', 'Deal Pipeline')
@section('page-title', 'Deal Pipeline')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('deals.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">List View</a>
        <a href="{{ route('deals.pipeline') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg">Pipeline View</a>
    </div>
    <a href="{{ route('deals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Deal
    </a>
</div>

<div class="flex gap-4 overflow-x-auto pb-4" x-data="pipelineBoard()">
    @foreach($stages as $stageKey => $stageInfo)
    @php
        $stageDeals = $dealsByStage[$stageKey];
        $totalValue = $stageDeals->sum('value');
        $stageColors = [
            'prospect' => 'bg-blue-50 border-blue-200',
            'proposal' => 'bg-purple-50 border-purple-200',
            'negotiation' => 'bg-orange-50 border-orange-200',
            'won' => 'bg-green-50 border-green-200',
            'lost' => 'bg-red-50 border-red-200',
        ];
        $headerColors = [
            'prospect' => 'bg-blue-600',
            'proposal' => 'bg-purple-600',
            'negotiation' => 'bg-orange-600',
            'won' => 'bg-green-600',
            'lost' => 'bg-red-600',
        ];
    @endphp
    <div class="flex-shrink-0 w-72">
        <!-- Column Header -->
        <div class="flex items-center justify-between mb-3 px-1">
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full {{ $headerColors[$stageKey] }}"></span>
                <h3 class="text-sm font-semibold text-gray-700">{{ $stageInfo['label'] }}</h3>
                <span class="bg-gray-200 text-gray-600 text-xs px-1.5 py-0.5 rounded-full">{{ $stageDeals->count() }}</span>
            </div>
            @if($totalValue > 0)
            <span class="text-xs text-gray-500">${{ number_format($totalValue, 0) }}</span>
            @endif
        </div>

        <!-- Cards -->
        <div class="space-y-3 min-h-24">
            @forelse($stageDeals as $deal)
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition cursor-pointer group"
                 onclick="window.location='{{ route('deals.show', $deal) }}'">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition line-clamp-2">{{ $deal->title }}</h4>
                    <div class="flex-shrink-0 ml-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('deals.edit', $deal) }}" onclick="event.stopPropagation()" class="text-gray-400 hover:text-blue-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                </div>
                @if($deal->account)
                <p class="text-xs text-gray-500 mb-2">{{ $deal->account->name }}</p>
                @endif
                <div class="flex items-center justify-between">
                    @if($deal->value)
                    <span class="text-sm font-semibold text-gray-900">${{ number_format($deal->value, 0) }}</span>
                    @else
                    <span class="text-xs text-gray-400">No value</span>
                    @endif
                    @if($deal->expected_close_date)
                    <span class="text-xs text-gray-500">{{ $deal->expected_close_date->format('M d') }}</span>
                    @endif
                </div>
                @if($deal->assignedTo)
                <div class="flex items-center mt-2 pt-2 border-t border-gray-100">
                    <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-medium mr-1.5">
                        {{ strtoupper(substr($deal->assignedTo->name, 0, 1)) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ $deal->assignedTo->name }}</span>
                </div>
                @endif
                <!-- Probability bar -->
                <div class="mt-2">
                    <div class="bg-gray-100 rounded-full h-1">
                        <div class="h-1 rounded-full {{ $headerColors[$stageKey] }}" style="width: {{ $deal->probability }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center">
                <p class="text-xs text-gray-400">No deals</p>
            </div>
            @endforelse
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
function pipelineBoard() {
    return {};
}
</script>
@endpush
@endsection
