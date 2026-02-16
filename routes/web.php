<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NurseryController;
use App\Http\Controllers\PlantController;
use App\Models\Nursery;

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

//Nursery Management(Create and view list of nurseries)
Route::post('/dashboard/nurseries/store', [NurseryController::class, 'store'])
    ->middleware('auth')
    ->name('dashboard.nurseries.store');

Route::middleware('auth')->match(['get', 'post'], '/dashboard/nurseries/{page?}', function ($page = 'index') {
    $allowedPages = ['index', 'create'];

    if (!in_array($page, $allowedPages)) {
        abort(404);
    }

    $data = ['page' => 'nurseries.' . $page];

    if ($page === 'index') {
        $controller = app(NurseryController::class);
        $response = $controller->index(); // returns ['nurseries' => Collection]
        $data['nurseries'] = $response['nurseries'] ?? collect([]);
    }

    return view('pages.dashboard.dashboard', $data);
})->name('dashboard.nurseries');

Route::get('/dashboard/nurseries/index/{nursery}',
    [NurseryController::class, 'show']
)->name('nursery.show');

Route::get('/dashboard/nurseries/index/{nursery}/plants/create',
    [PlantController::class, 'create']
)->name('plants.create');

Route::post('/dashboard/nurseries/index/{nursery}/plants',
    [PlantController::class, 'store']
)->name('plants.store');


Route::get('/dashboard/nurseries/index/{nursery}', function (Nursery $nursery) {
    return view('pages.dashboard.nurseries.nursery', compact('nursery'));
})->name('nursery.show');


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return view('login');
})->name('logout');

