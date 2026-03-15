<?php

namespace Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounts\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('accounts::index');
    }

    public function create()
    {
        return view('accounts::create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:100',
            'employees_count' => 'nullable|integer|min:0',
            'annual_revenue' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        Account::create($data);
        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $account->load(['createdBy', 'contacts', 'deals']);
        return view('accounts::show', compact('account'));
    }

    public function edit(Account $account)
    {
        return view('accounts::edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:100',
            'employees_count' => 'nullable|integer|min:0',
            'annual_revenue' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        $account->update($data);
        return redirect()->route('accounts.show', $account)->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
