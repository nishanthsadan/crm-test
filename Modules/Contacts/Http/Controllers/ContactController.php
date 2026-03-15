<?php

namespace Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Contacts\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts::index');
    }

    public function create()
    {
        $accounts = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('accounts')) {
            $accounts = \Illuminate\Support\Facades\DB::table('accounts')->orderBy('name')->get();
        }
        return view('contacts::create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'account_id' => 'nullable|exists:accounts,id',
            'title' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        Contact::create($data);
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        $contact->load(['account', 'createdBy']);
        return view('contacts::show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $accounts = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('accounts')) {
            $accounts = \Illuminate\Support\Facades\DB::table('accounts')->orderBy('name')->get();
        }
        return view('contacts::edit', compact('contact', 'accounts'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'account_id' => 'nullable|exists:accounts,id',
            'title' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $contact->update($data);
        return redirect()->route('contacts.show', $contact)->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
