@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Leads -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                +{{ $stats['leads_this_month'] }} this month
            </span>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_leads']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Leads</p>
        </div>
    </div>

    <!-- Total Contacts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_contacts']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Contacts</p>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                {{ $stats['deals_won_this_month'] }} won this month
            </span>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Revenue (Won Deals)</p>
        </div>
    </div>

    <!-- Conversion Rate -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-orange-100 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['conversion_rate'] }}%</p>
            <p class="text-sm text-gray-500 mt-1">Lead Conversion Rate</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Leads vs Deals Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Leads & Won Deals (6 Months)</h3>
        <canvas id="leadsDealsChart" height="200"></canvas>
    </div>

    <!-- Pipeline Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deal Pipeline Overview</h3>
        <canvas id="pipelineChart" height="200"></canvas>
    </div>
</div>

<!-- Bottom Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
            <a href="{{ route('activities.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
        </div>

        @if(count($recentActivities) > 0)
        <div class="space-y-3">
            @foreach($recentActivities as $activity)
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="p-1.5 bg-blue-100 rounded-full flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->title }}</p>
                    <p class="text-xs text-gray-500">{{ $activity->assigned_name }} · {{ ucfirst($activity->type) }}</p>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path>
            </svg>
            <p class="text-sm">No recent activities</p>
        </div>
        @endif
    </div>

    <!-- Upcoming Tasks -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Upcoming Tasks</h3>
            <a href="{{ route('activities.index') }}?type=task" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
        </div>

        @if(count($upcomingTasks) > 0)
        <div class="space-y-3">
            @foreach($upcomingTasks as $task)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 rounded-full {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                        <p class="text-xs text-gray-500">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                    </div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-sm">No upcoming tasks</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Leads vs Deals Chart
const leadsDealsCtx = document.getElementById('leadsDealsChart').getContext('2d');
new Chart(leadsDealsCtx, {
    type: 'line',
    data: {
        labels: @json($chartData['months']),
        datasets: [{
            label: 'Leads',
            data: @json($chartData['leads']),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Won Deals',
            data: @json($chartData['deals_won']),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Pipeline Chart
const pipelineCtx = document.getElementById('pipelineChart').getContext('2d');
new Chart(pipelineCtx, {
    type: 'doughnut',
    data: {
        labels: ['Prospect', 'Proposal', 'Negotiation', 'Won', 'Lost'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444'],
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
@endsection
