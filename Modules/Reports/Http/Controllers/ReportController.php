<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = $this->getSummaryData();
        return view('reports::index', compact('data'));
    }

    public function leads()
    {
        $data = [];
        if (Schema::hasTable('leads')) {
            $data['by_status'] = DB::table('leads')->select('status', DB::raw('count(*) as count'))->groupBy('status')->get();
            $data['by_source'] = DB::table('leads')->select('source', DB::raw('count(*) as count'))->whereNotNull('source')->groupBy('source')->get();
            $data['by_priority'] = DB::table('leads')->select('priority', DB::raw('count(*) as count'))->groupBy('priority')->get();
            $data['monthly'] = DB::table('leads')
                ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->whereYear('created_at', now()->year)
                ->groupBy('year', 'month')
                ->orderBy('month')
                ->get();
        }
        return view('reports::leads', compact('data'));
    }

    public function deals()
    {
        $data = [];
        if (Schema::hasTable('deals')) {
            $data['by_stage'] = DB::table('deals')->select('stage', DB::raw('count(*) as count'), DB::raw('SUM(value) as total_value'))->groupBy('stage')->get();
            $data['total_pipeline'] = DB::table('deals')->whereNotIn('stage', ['won', 'lost'])->sum('value');
            $data['total_won'] = DB::table('deals')->where('stage', 'won')->sum('value');
            $data['monthly_won'] = DB::table('deals')
                ->select(DB::raw('YEAR(updated_at) as year'), DB::raw('MONTH(updated_at) as month'), DB::raw('SUM(value) as total'))
                ->where('stage', 'won')
                ->whereYear('updated_at', now()->year)
                ->groupBy('year', 'month')
                ->orderBy('month')
                ->get();
        }
        return view('reports::deals', compact('data'));
    }

    public function activities()
    {
        $data = [];
        if (Schema::hasTable('activities')) {
            $data['by_type'] = DB::table('activities')->select('type', DB::raw('count(*) as count'))->groupBy('type')->get();
            $data['by_status'] = DB::table('activities')->select('status', DB::raw('count(*) as count'))->groupBy('status')->get();
            $data['completion_rate'] = 0;
            $total = DB::table('activities')->count();
            if ($total > 0) {
                $completed = DB::table('activities')->where('status', 'completed')->count();
                $data['completion_rate'] = round(($completed / $total) * 100, 1);
            }
        }
        return view('reports::activities', compact('data'));
    }

    public function exportLeads()
    {
        if (!Schema::hasTable('leads')) {
            return back()->with('error', 'No leads data available.');
        }

        $leads = DB::table('leads')
            ->leftJoin('users as assignee', 'leads.assigned_to', '=', 'assignee.id')
            ->select('leads.*', 'assignee.name as assigned_name')
            ->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="leads.csv"'];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Company', 'Status', 'Priority', 'Source', 'Expected Value', 'Assigned To', 'Created At']);
            foreach ($leads as $lead) {
                fputcsv($file, [$lead->id, $lead->first_name, $lead->last_name, $lead->email, $lead->phone, $lead->company, $lead->status, $lead->priority, $lead->source, $lead->expected_value, $lead->assigned_name, $lead->created_at]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportDeals()
    {
        if (!Schema::hasTable('deals')) {
            return back()->with('error', 'No deals data available.');
        }

        $deals = DB::table('deals')
            ->leftJoin('accounts', 'deals.account_id', '=', 'accounts.id')
            ->leftJoin('users', 'deals.assigned_to', '=', 'users.id')
            ->select('deals.*', 'accounts.name as account_name', 'users.name as assigned_name')
            ->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="deals.csv"'];

        $callback = function () use ($deals) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Title', 'Account', 'Stage', 'Value', 'Probability', 'Expected Close', 'Assigned To', 'Created At']);
            foreach ($deals as $deal) {
                fputcsv($file, [$deal->id, $deal->title, $deal->account_name, $deal->stage, $deal->value, $deal->probability, $deal->expected_close_date, $deal->assigned_name, $deal->created_at]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getSummaryData(): array
    {
        return [
            'total_leads' => Schema::hasTable('leads') ? DB::table('leads')->count() : 0,
            'total_contacts' => Schema::hasTable('contacts') ? DB::table('contacts')->count() : 0,
            'total_deals' => Schema::hasTable('deals') ? DB::table('deals')->count() : 0,
            'pipeline_value' => Schema::hasTable('deals') ? DB::table('deals')->whereNotIn('stage', ['won', 'lost'])->sum('value') : 0,
            'won_value' => Schema::hasTable('deals') ? DB::table('deals')->where('stage', 'won')->sum('value') : 0,
            'open_activities' => Schema::hasTable('activities') ? DB::table('activities')->whereIn('status', ['pending', 'in_progress'])->count() : 0,
        ];
    }
}
