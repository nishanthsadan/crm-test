<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getStats();
        $chartData = $this->getChartData();
        $recentActivities = $this->getRecentActivities();
        $upcomingTasks = $this->getUpcomingTasks();

        return view('dashboard::index', compact('stats', 'chartData', 'recentActivities', 'upcomingTasks'));
    }

    private function getStats(): array
    {
        $stats = [
            'total_leads' => 0,
            'total_contacts' => 0,
            'total_deals' => 0,
            'total_revenue' => 0,
            'leads_this_month' => 0,
            'deals_won_this_month' => 0,
            'open_activities' => 0,
            'conversion_rate' => 0,
        ];

        try {
            if (Schema::hasTable('leads')) {
                $stats['total_leads'] = DB::table('leads')->count();
                $stats['leads_this_month'] = DB::table('leads')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
            }

            if (Schema::hasTable('contacts')) {
                $stats['total_contacts'] = DB::table('contacts')->count();
            }

            if (Schema::hasTable('deals')) {
                $stats['total_deals'] = DB::table('deals')->count();
                $stats['total_revenue'] = DB::table('deals')
                    ->where('stage', 'won')
                    ->sum('value') ?? 0;
                $stats['deals_won_this_month'] = DB::table('deals')
                    ->where('stage', 'won')
                    ->whereMonth('updated_at', now()->month)
                    ->count();
            }

            if (Schema::hasTable('activities')) {
                $stats['open_activities'] = DB::table('activities')
                    ->whereIn('status', ['pending', 'in_progress'])
                    ->count();
            }

            if ($stats['total_leads'] > 0) {
                $converted = Schema::hasTable('leads')
                    ? DB::table('leads')->where('status', 'converted')->count()
                    : 0;
                $stats['conversion_rate'] = round(($converted / $stats['total_leads']) * 100, 1);
            }
        } catch (\Exception $e) {
            // Tables might not exist yet
        }

        return $stats;
    }

    private function getChartData(): array
    {
        $months = [];
        $leadsData = [];
        $dealsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');

            try {
                $leadsData[] = Schema::hasTable('leads')
                    ? DB::table('leads')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count()
                    : 0;
                $dealsData[] = Schema::hasTable('deals')
                    ? DB::table('deals')->where('stage', 'won')->whereMonth('updated_at', $date->month)->whereYear('updated_at', $date->year)->count()
                    : 0;
            } catch (\Exception $e) {
                $leadsData[] = 0;
                $dealsData[] = 0;
            }
        }

        return [
            'months' => $months,
            'leads' => $leadsData,
            'deals_won' => $dealsData,
        ];
    }

    private function getRecentActivities(): array
    {
        try {
            if (!Schema::hasTable('activities')) return [];

            return DB::table('activities')
                ->join('users', 'activities.assigned_to', '=', 'users.id')
                ->select('activities.*', 'users.name as assigned_name')
                ->orderBy('activities.created_at', 'desc')
                ->limit(5)
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getUpcomingTasks(): array
    {
        try {
            if (!Schema::hasTable('activities')) return [];

            return DB::table('activities')
                ->where('type', 'task')
                ->whereIn('status', ['pending', 'in_progress'])
                ->where('due_date', '>=', now()->toDateString())
                ->orderBy('due_date', 'asc')
                ->limit(5)
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}
