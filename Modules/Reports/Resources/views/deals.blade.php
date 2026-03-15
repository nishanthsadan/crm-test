@extends('layouts.app')
@section('title', 'Deals Report')
@section('page-title', 'Deals Report')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:text-blue-700 mr-2">← Back to Reports</a>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-2xl font-bold text-indigo-600">${{ number_format($data['total_pipeline'] ?? 0, 0) }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Pipeline</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-2xl font-bold text-green-600">${{ number_format($data['total_won'] ?? 0, 0) }}</p>
        <p class="text-sm text-gray-500 mt-1">Won Revenue</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-2xl font-bold text-blue-600">{{ count($data['by_stage'] ?? []) }}</p>
        <p class="text-sm text-gray-500 mt-1">Active Stages</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- By Stage (Count) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Deals by Stage</h3>
        <canvas id="stageCountChart" height="220"></canvas>
    </div>

    {{-- By Stage (Value) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Value by Stage ($)</h3>
        <canvas id="stageValueChart" height="220"></canvas>
    </div>
</div>

{{-- Monthly Won Revenue --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Monthly Won Revenue ({{ now()->year }})</h3>
    <canvas id="monthlyWonChart" height="100"></canvas>
</div>

{{-- Stage Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Stage Breakdown</h3>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stage</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Count</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Value</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($data['by_stage'] ?? [] as $stage)
            @php
                $stageColors = ['prospect'=>'bg-blue-100 text-blue-800','proposal'=>'bg-purple-100 text-purple-800','negotiation'=>'bg-orange-100 text-orange-800','won'=>'bg-green-100 text-green-800','lost'=>'bg-red-100 text-red-800'];
                $color = $stageColors[$stage->stage] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                        {{ ucfirst($stage->stage) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-right text-sm text-gray-900">{{ number_format($stage->count) }}</td>
                <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">${{ number_format($stage->total_value ?? 0, 0) }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No deal data available.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    <a href="{{ route('reports.export.deals') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export Deals (CSV)
    </a>
</div>

@push('scripts')
<script>
const stageData  = @json($data['by_stage'] ?? []);
const monthlyWon = @json($data['monthly_won'] ?? []);

const stageLabels = stageData.map(d => d.stage.charAt(0).toUpperCase() + d.stage.slice(1));
const stageCounts = stageData.map(d => d.count);
const stageValues = stageData.map(d => d.total_value || 0);
const stageColors = ['#3b82f6','#8b5cf6','#f97316','#10b981','#ef4444'];

// Stage Count Chart
new Chart(document.getElementById('stageCountChart'), {
    type: 'doughnut',
    data: {
        labels: stageLabels,
        datasets: [{ data: stageCounts, backgroundColor: stageColors }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Stage Value Chart
new Chart(document.getElementById('stageValueChart'), {
    type: 'bar',
    data: {
        labels: stageLabels,
        datasets: [{ label: 'Value ($)', data: stageValues, backgroundColor: stageColors }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => '$' + v.toLocaleString() } } }
    }
});

// Monthly Won Revenue
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const wonTotals = new Array(12).fill(0);
monthlyWon.forEach(d => wonTotals[d.month - 1] = d.total || 0);

new Chart(document.getElementById('monthlyWonChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ label: 'Won Revenue ($)', data: wonTotals, backgroundColor: 'rgba(16, 185, 129, 0.8)' }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { callback: v => '$' + v.toLocaleString() } } }
    }
});
</script>
@endpush
@endsection
