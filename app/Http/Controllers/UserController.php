<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::select('id', 'name', 'email', 'role', 'created_at')->latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => array_map(fn ($r) => ['value' => $r->value, 'name' => $r->name], UserRole::cases()),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user'  => $user->only('id', 'name', 'email', 'role'),
            'roles' => array_map(fn ($r) => ['value' => $r->value, 'name' => $r->name], UserRole::cases()),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
