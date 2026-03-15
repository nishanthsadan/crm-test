@extends('layouts.app')
@section('title', 'Leads Report')
@section('page-title', 'Leads Report')
@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('reports.index') }}" class="text-sm text-blue-600 hover:text-blue-700 mr-2">← Back to Reports</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- By Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">By Status</h3>
        <canvas id="statusChart" height="200"></canvas>
    </div>
    <!-- By Source -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">By Source</h3>
        <canvas id="sourceChart" height="200"></canvas>
    </div>
    <!-- By Priority -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">By Priority</h3>
        <canvas id="priorityChart" height="200"></canvas>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Monthly Leads ({{ now()->year }})</h3>
    <canvas id="monthlyChart" height="100"></canvas>
</div>

@push('scripts')
<script>
const statusData = @json($data['by_status'] ?? []);
const sourceData = @json($data['by_source'] ?? []);
const priorityData = @json($data['by_priority'] ?? []);
const monthlyData = @json($data['monthly'] ?? []);

// Status Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(d => d.status),
        datasets: [{ data: statusData.map(d => d.count), backgroundColor: ['#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444', '#10b981'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Source Chart
new Chart(document.getElementById('sourceChart'), {
    type: 'bar',
    data: {
        labels: sourceData.map(d => d.source),
        datasets: [{ label: 'Leads', data: sourceData.map(d => d.count), backgroundColor: '#3b82f6' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// Priority Chart
new Chart(document.getElementById('priorityChart'), {
    type: 'doughnut',
    data: {
        labels: priorityData.map(d => d.priority),
        datasets: [{ data: priorityData.map(d => d.count), backgroundColor: ['#10b981', '#f59e0b', '#ef4444'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Monthly Chart
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const monthlyCounts = new Array(12).fill(0);
monthlyData.forEach(d => monthlyCounts[d.month - 1] = d.count);

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ label: 'New Leads', data: monthlyCounts, backgroundColor: 'rgba(59, 130, 246, 0.8)' }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
@endsection
