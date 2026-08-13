<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('settings.index', compact('users'));
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff',
            'email' => 'nullable|email|unique:users,email|required_if:role,admin',
            'password' => 'nullable|string|min:6|required_if:role,admin',
            'pin' => 'nullable|digits:6|required_if:role,staff',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->role = $validated['role'];

        if ($validated['role'] === 'admin') {
            $user->email = $validated['email'];
            $user->password = $validated['password'];
        } else {
            $user->email = strtolower(str_replace(' ', '.', $validated['name'])) . '@staff.local';
            $user->password = bcrypt(str()->random(32));
            $user->pin = $validated['pin'];
        }

        $user->save();

        return redirect()->route('settings.index')->with('success', 'User account created.');
    }

    public function edit(User $user)
    {
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pin' => 'nullable|digits:6',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $validated['name'];

        if ($user->role === 'staff' && !empty($validated['pin'])) {
            $user->pin = $validated['pin'];
        }

        if ($user->role === 'admin' && !empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('settings.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('settings.index')->with('error', "You can't delete your own account.");
        }

        $user->delete();
        return redirect()->route('settings.index')->with('success', 'User removed.');
    }
}