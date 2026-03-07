<?php

use App\Enums\UserRole;
use App\Http\Controllers\AiSireController;
use App\Http\Controllers\CowController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home', [
            'stats' => [
                'totalUsers'      => User::count(),
                'adminCount'      => User::where('role', UserRole::Admin)->count(),
                'subscriberCount' => User::where('role', UserRole::Subscriber)->count(),
            ],
        ]);
    })->name('home');

    Route::resource('users', UserController::class)->only(['index', 'destroy']);

    Route::resource('users', UserController::class)
        ->only(['create', 'store', 'edit', 'update'])
        ->middleware('admin');

    Route::resource('cows', CowController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('ai-sires', AiSireController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});
