<?php

namespace Modules\Activities\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Activities\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        return view('activities::index');
    }

    public function create()
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        $actableType = request('actable_type');
        $actableId = request('actable_id');
        return view('activities::create', compact('users', 'actableType', 'actableId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:call,meeting,task,email',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'actable_type' => 'nullable|string',
            'actable_id' => 'nullable|integer',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Map actable_type to full class name
        if (!empty($data['actable_type'])) {
            $typeMap = [
                'lead' => 'Modules\\Leads\\Models\\Lead',
                'contact' => 'Modules\\Contacts\\Models\\Contact',
                'deal' => 'Modules\\Deals\\Models\\Deal',
                'account' => 'Modules\\Accounts\\Models\\Account',
            ];
            $data['actable_type'] = $typeMap[$data['actable_type']] ?? $data['actable_type'];
        }

        $data['created_by'] = Auth::id();
        Activity::create($data);
        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity)
    {
        $activity->load(['assignedTo', 'createdBy', 'actable']);
        return view('activities::show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $users = User::where('status', 'active')->orderBy('name')->get();
        return view('activities::edit', compact('activity', 'users'));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'type' => 'required|in:call,meeting,task,email',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $activity->update($data);
        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity deleted.');
    }

    public function complete(Activity $activity)
    {
        $activity->update(['status' => 'completed']);
        return back()->with('success', 'Activity marked as completed.');
    }
}
