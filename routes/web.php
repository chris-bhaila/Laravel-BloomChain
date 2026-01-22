<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware('auth')->get('/landing', function () {
    return view('landing');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return view('login');
})->name('logout');

Route::get('/dashboard', function (){
    return view('dashboard');
})->name('dashboard');

Route::get('/pages/users/{subpage}', [PageController::class, 'showSubPage'])->name('users.subpage');
