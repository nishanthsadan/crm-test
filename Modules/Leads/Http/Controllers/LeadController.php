<?php

namespace Modules\Leads\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Leads\Models\Lead;
use Modules\Leads\Http\Requests\LeadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        return view('leads::index');
    }

    public function create()
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        return view('leads::create', compact('users'));
    }

    public function store(LeadRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        Lead::create($data);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load(['assignedTo', 'createdBy']);
        return view('leads::show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        return view('leads::edit', compact('lead', 'users'));
    }

    public function update(LeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());
        return redirect()->route('leads.show', $lead)->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function convert(Lead $lead)
    {
        // Update lead status
        $lead->update(['status' => 'converted']);

        // Create contact from lead
        if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
            \Illuminate\Support\Facades\DB::table('contacts')->insert([
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'source' => $lead->source,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('leads.show', $lead)->with('success', 'Lead converted to contact successfully.');
    }
}
