<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => Inertia::render('Home'));

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('users', UserController::class)->only(['index', 'destroy']);

    Route::resource('users', UserController::class)
        ->only(['create', 'store', 'edit', 'update'])
        ->middleware('admin');
});
