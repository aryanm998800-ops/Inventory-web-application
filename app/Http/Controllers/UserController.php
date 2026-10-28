<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private function availableRoles()
    {
        return Role::where('guard_name', 'web')
            ->whereIn('name', ['Admin', 'Manager', 'Staff'])
            ->orderBy('name')
            ->get();
    }

    public function index()
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(10);

        return view('Users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->availableRoles();

        return view('Users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
            'role' => [
                'required',
                Rule::in(['Admin', 'Manager', 'Staff']),
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'is_active' => true,
            ]);

            $user->assignRole($validated['role']);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles');

        return view('Users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = $this->availableRoles();

        $user->load('roles');

        return view('Users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
            'role' => [
                'required',
                Rule::in(['Admin', 'Manager', 'Staff']),
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $isActive = $request->boolean('is_active');
        $isCurrentUser = (int) $user->id === (int) auth()->id();

        // The logged-in user cannot remove their own Admin access
        // or deactivate their own account.
        if (
            $isCurrentUser
            && ($validated['role'] !== 'Admin' || !$isActive)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'You cannot remove your own Admin role or deactivate your own account.',
                ]);
        }

        $removingAdminAccess = $user->hasRole('Admin')
            && ($validated['role'] !== 'Admin' || !$isActive);

        if ($user->is_active && $removingAdminAccess) {
            $activeAdminCount = User::where('is_active', true)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Admin')
                        ->where('guard_name', 'web');
                })
                ->count();

            if ($activeAdminCount <= 1) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'role' => 'The last active Admin cannot be demoted or deactivated. Assign another active Admin first.',
                    ]);
            }
        }

        DB::transaction(function () use (
            $validated,
            $user,
            $isActive
        ) {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->is_active = $isActive;

            if (!empty($validated['password'])) {
                $user->password = $validated['password'];
            }

            $user->save();

            $user->syncRoles([$validated['role']]);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ((int) $user->id === (int) auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot deactivate your own account.',
            ]);
        }

        if ($user->is_active && $user->hasRole('Admin')) {
            $activeAdminCount = User::where('is_active', true)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Admin')
                        ->where('guard_name', 'web');
                })
                ->count();

            if ($activeAdminCount <= 1) {
                return back()->withErrors([
                    'user' => 'The last active Admin account cannot be deactivated. Assign another active Admin first.',
                ]);
            }
        }

        // Deactivate instead of permanently deleting the user.
        $user->is_active = false;
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deactivated successfully.');
    }
}