<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::count(),
            'active_users'   => User::where('status', 'active')->count(),
            'total_modules'  => 10,
            'enabled_modules' => $this->getEnabledModulesCount(),
        ];
        return view('settings::index', compact('stats'));
    }

    // ── Profile ──────────────────────────────────────────────────────────────

    public function profile()
    {
        $user = Auth::user();
        return view('settings::profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }

    // ── Users ─────────────────────────────────────────────────────────────────

    public function users()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('settings::users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::orderBy('name')->pluck('name');
        return view('settings::users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,manager,user',
            'phone'    => 'nullable|string|max:20',
            'status'   => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'phone'    => $data['phone'] ?? null,
            'status'   => $data['status'],
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('settings.users.index')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name');
        return view('settings::users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'     => 'required|in:admin,manager,user',
            'phone'    => 'nullable|string|max:20',
            'status'   => 'required|in:active,inactive',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $updateData = [
            'name'   => $data['name'],
            'email'  => $data['email'],
            'role'   => $data['role'],
            'phone'  => $data['phone'] ?? null,
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        $user->syncRoles([$data['role']]);

        return redirect()->route('settings.users.index')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('settings.users.index')->with('success', 'User deleted successfully.');
    }

    // ── Modules ───────────────────────────────────────────────────────────────

    public function modules()
    {
        $coreModules = ['Core', 'Auth', 'Dashboard'];
        $allModules  = ['Core', 'Auth', 'Dashboard', 'Leads', 'Contacts', 'Accounts', 'Deals', 'Activities', 'Reports', 'Settings'];

        $moduleStatuses = [];
        foreach ($allModules as $module) {
            $moduleStatuses[$module] = [
                'name'    => $module,
                'enabled' => $this->isModuleEnabled($module),
                'core'    => in_array($module, $coreModules),
            ];
        }

        return view('settings::modules', compact('moduleStatuses'));
    }

    public function toggleModule(Request $request, string $module)
    {
        $coreModules = ['Core', 'Auth', 'Dashboard', 'Settings'];

        if (in_array($module, $coreModules)) {
            return back()->with('error', "The {$module} module cannot be disabled.");
        }

        $current = $this->isModuleEnabled($module);
        $newState = !$current;

        DB::table('modules_status')->updateOrInsert(
            ['module_name' => $module],
            ['is_enabled' => $newState, 'updated_at' => now()]
        );

        Cache::forget("module_enabled_{$module}");

        $action = $newState ? 'enabled' : 'disabled';
        return back()->with('success', "{$module} module {$action} successfully.");
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function isModuleEnabled(string $module): bool
    {
        try {
            $result = DB::table('modules_status')
                ->where('module_name', $module)
                ->value('is_enabled');
            return (bool) ($result ?? true);
        } catch (\Exception $e) {
            return true;
        }
    }

    private function getEnabledModulesCount(): int
    {
        $modules = ['Leads', 'Contacts', 'Accounts', 'Deals', 'Activities', 'Reports', 'Settings'];
        $count   = 0;
        foreach ($modules as $module) {
            if ($this->isModuleEnabled($module)) {
                $count++;
            }
        }
        return $count + 3; // Core, Auth, Dashboard always enabled
    }
}
