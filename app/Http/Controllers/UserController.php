<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(SearchRequest $request)
    {
        $params = [
            'search' => $request->search,
        ];

        $users = UserResource::collection(
            User::search($params)->latest()->paginate()->withQueryString()
        );

        $breadcrumbs = [
            ['label' => 'Users', 'url' => ''],
        ];

        return Inertia::render('User/Index', [
            'search'      => $request->search,
            'users'       => $users,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Users', 'url' => route('users.index')],
            ['label' => 'Add New User', 'url' => ''],
        ];

        return Inertia::render('User/Create', [
            'roles'       => array_map(fn ($r) => ['value' => $r->value, 'name' => $r->name], UserRole::cases()),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function store(StoreRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $breadcrumbs = [
            ['label' => 'Users', 'url' => route('users.index')],
            ['label' => 'Edit User', 'url' => ''],
        ];

        return Inertia::render('User/Edit', [
            'user'        => new UserResource($user),
            'roles'       => array_map(fn ($r) => ['value' => $r->value, 'name' => $r->name], UserRole::cases()),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
