<?php

namespace Modules\Deals\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Deals\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{
    public function index()
    {
        return view('deals::index');
    }

    public function pipeline()
    {
        $stages = Deal::STAGES;
        $dealsByStage = [];

        foreach (array_keys($stages) as $stage) {
            $query = Deal::with(['account', 'assignedTo'])->where('stage', $stage);
            if (!auth()->user()->hasRole(['admin', 'manager'])) {
                $query->forUser(Auth::id());
            }
            $dealsByStage[$stage] = $query->orderBy('value', 'desc')->get();
        }

        return view('deals::pipeline', compact('stages', 'dealsByStage'));
    }

    public function create()
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        $accounts = Schema::hasTable('accounts') ? DB::table('accounts')->orderBy('name')->get() : collect();
        $contacts = Schema::hasTable('contacts') ? DB::table('contacts')->orderBy('first_name')->get() : collect();
        return view('deals::create', compact('users', 'accounts', 'contacts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id',
            'stage' => 'required|in:prospect,proposal,negotiation,won,lost',
            'value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        $data['currency'] = $data['currency'] ?? 'USD';
        Deal::create($data);
        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    public function show(Deal $deal)
    {
        $deal->load(['account', 'contact', 'assignedTo', 'createdBy']);
        return view('deals::show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        $accounts = Schema::hasTable('accounts') ? DB::table('accounts')->orderBy('name')->get() : collect();
        $contacts = Schema::hasTable('contacts') ? DB::table('contacts')->orderBy('first_name')->get() : collect();
        return view('deals::edit', compact('deal', 'users', 'accounts', 'contacts'));
    }

    public function update(Request $request, Deal $deal)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id',
            'stage' => 'required|in:prospect,proposal,negotiation,won,lost',
            'value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        $deal->update($data);
        return redirect()->route('deals.show', $deal)->with('success', 'Deal updated successfully.');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }

    public function updateStage(Request $request, Deal $deal)
    {
        $request->validate(['stage' => 'required|in:prospect,proposal,negotiation,won,lost']);
        $deal->update(['stage' => $request->stage]);
        return response()->json(['success' => true]);
    }
}
