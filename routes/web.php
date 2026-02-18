<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\NurseryController;
use App\Http\Controllers\PlantController;
use App\Models\Nursery;

//Public Routes

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');


//Protected Routes

Route::middleware('auth')->group(function () {

    // ✅ Nursery routes FIRST (before the dashboard wildcard)
    Route::post('/dashboard/nurseries/store', [NurseryController::class, 'store'])
        ->name('dashboard.nurseries.store');

    Route::get('/dashboard/nurseries/show/{nursery}', function (Nursery $nursery) {
        if ($nursery->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pages.dashboard.dashboard', [
            'page'    => 'nurseries.nursery',
            'nursery' => $nursery->load('plants'),
        ]);
    })->name('nursery.show');

    Route::get('/dashboard/nurseries/show/{nursery}/plants/create', [PlantController::class, 'create'])
        ->name('plants.create');

    Route::post('/dashboard/nurseries/show/{nursery}/plants', [PlantController::class, 'store'])
        ->name('plants.store');

    Route::get('/plants/file/{filename}', [PlantController::class, 'viewFile'])
        ->name('plants.file');

    Route::get('/nursery/file/{filename}', [NurseryController::class, 'viewFile'])
        ->name('nursery.file');

    // ✅ Nursery wildcard BEFORE dashboard wildcard
    Route::match(['get', 'post'], '/dashboard/nurseries/{page?}', function ($page = 'index') {
        $allowedPages = ['index', 'create'];
        if (!in_array($page, $allowedPages)) {
            abort(404);
        }
        $data = ['page' => 'nurseries.' . $page];
        if ($page === 'index') {
            $controller = app(NurseryController::class);
            $response   = $controller->index();
            $data['nurseries'] = $response['nurseries'] ?? collect([]);
        }
        return view('pages.dashboard.dashboard', $data);
    })->name('dashboard.nurseries');

    // ✅ Dashboard wildcard LAST
    Route::match(['get', 'post'], '/dashboard/{page?}', function ($page = 'profile') {
        return view('pages.dashboard.dashboard', ['page' => $page]);
    })->name('dashboard');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});