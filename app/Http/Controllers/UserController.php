<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
     
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:3|confirmed',
            'role' => 'required|string|in:admin,seller',
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
     
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,'. $user->id,
            'role' => 'required|string|in:admin,seller',
            'password' => 'required|string|min:3'
        ]);

        $password = Hash::make($request->password);

        $user->update([
            'name' => $request->name,
    'role' => $request->role,
    'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
