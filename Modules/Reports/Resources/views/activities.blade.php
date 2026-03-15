@extends('layouts.app')
@section('title', 'Activities Report')
@section('page-title', 'Activities Report')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:text-blue-700 mr-2">← Back to Reports</a>
</div>

{{-- Completion Rate Card --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $data['completion_rate'] ?? 0 }}%</p>
        <p class="text-sm text-gray-500 mt-1">Completion Rate</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        @php $totalActivities = collect($data['by_status'] ?? [])->sum('count'); @endphp
        <p class="text-3xl font-bold text-blue-600">{{ number_format($totalActivities) }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Activities</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        @php $completed = collect($data['by_status'] ?? [])->where('status','completed')->first(); @endphp
        <p class="text-3xl font-bold text-purple-600">{{ number_format($completed->count ?? 0) }}</p>
        <p class="text-sm text-gray-500 mt-1">Completed</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- By Type --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">By Activity Type</h3>
        <canvas id="typeChart" height="220"></canvas>
    </div>

    {{-- By Status --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">By Status</h3>
        <canvas id="statusChart" height="220"></canvas>
    </div>
</div>

{{-- Completion Rate Bar --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Completion Progress</h3>
    <div class="space-y-3">
        @foreach($data['by_status'] ?? [] as $status)
        @php
            $pct = $totalActivities > 0 ? round(($status->count / $totalActivities) * 100) : 0;
            $barColors = ['pending'=>'bg-yellow-400','in_progress'=>'bg-blue-400','completed'=>'bg-green-400','cancelled'=>'bg-red-400'];
            $barColor = $barColors[$status->status] ?? 'bg-gray-400';
        @endphp
        <div>
            <div class="flex justify-between text-xs text-gray-600 mb-1">
                <span class="font-medium capitalize">{{ str_replace('_',' ', $status->status) }}</span>
                <span>{{ number_format($status->count) }} ({{ $pct }}%)</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
            </div>
        </div>
        @endforeach
        @if(empty($data['by_status']))
        <p class="text-sm text-gray-400 text-center py-4">No activity data available.</p>
        @endif
    </div>
</div>

@push('scripts')
<script>
const typeData   = @json($data['by_type'] ?? []);
const statusData = @json($data['by_status'] ?? []);

const typeColors   = ['#3b82f6','#10b981','#f59e0b','#8b5cf6'];
const statusColors = ['#f59e0b','#3b82f6','#10b981','#ef4444'];

// By Type
if (typeData.length > 0) {
    new Chart(document.getElementById('typeChart'), {
        type: 'doughnut',
        data: {
            labels: typeData.map(d => d.type.charAt(0).toUpperCase() + d.type.slice(1)),
            datasets: [{ data: typeData.map(d => d.count), backgroundColor: typeColors }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
} else {
    document.getElementById('typeChart').parentElement.innerHTML += '<p class="text-center text-gray-400 text-sm py-4">No data available</p>';
    document.getElementById('typeChart').remove();
}

// By Status
if (statusData.length > 0) {
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: statusData.map(d => d.status.replace('_',' ').replace(/\b\w/g, c => c.toUpperCase())),
            datasets: [{ label: 'Activities', data: statusData.map(d => d.count), backgroundColor: statusColors }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
} else {
    document.getElementById('statusChart').parentElement.innerHTML += '<p class="text-center text-gray-400 text-sm py-4">No data available</p>';
    document.getElementById('statusChart').remove();
}
</script>
@endpush
@endsection
