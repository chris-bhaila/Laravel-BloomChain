<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NurseryController;

// Login page
Route::get('/', function () {
    return view('login');
})->name('login');

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Dashboard (protected)
Route::middleware('auth')->match(['get', 'post'], '/dashboard/{page?}', function ($page = 'profile') {
    return view("pages.dashboard.dashboard", ['page' => $page]);
})->name('dashboard');

//Nursery Management
Route::middleware(['auth'])->group(function () {
    Route::get('/nurseries/index', [NurseryController::class, 'index'])->name('nurseries.index');
    Route::get('/nurseries/create', [NurseryController::class, 'create'])->name('nurseries.create');
    Route::get('/nurseries', [NurseryController::class, 'store'])->name('nurseries.store');
});


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return view('login');
})->name('logout');

