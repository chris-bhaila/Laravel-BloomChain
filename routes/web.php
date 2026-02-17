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

    //General Dashboard
    Route::match(['get', 'post'], '/dashboard/{page?}', function ($page = 'profile') {
        return view('pages.dashboard.dashboard', ['page' => $page]);
    })->name('dashboard');


    /*
    | Nursery Routes
    | Order matters — specific routes must come before the wildcard
    */

    // Secure file viewing
    Route::get('/nursery/file/{filename}', [NurseryController::class, 'viewFile'])
        ->name('nursery.file');

    // Store a new nursery
    Route::post('/dashboard/nurseries/store', [NurseryController::class, 'store'])
        ->name('dashboard.nurseries.store');

    // Show a single nursery (must be before the {page?} wildcard)
    Route::get('/dashboard/nurseries/show/{nursery}', function (Nursery $nursery) {
        // Ensure the authenticated user owns this nursery
        if ($nursery->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.dashboard.dashboard', [
            'page'    => 'nurseries.nursery',
            'nursery' => $nursery->load('plants'),
        ]);
    })->name('nursery.show');


    //Plant Routes
    Route::get('/dashboard/nurseries/show/{nursery}/plants/create', [PlantController::class, 'create'])
        ->name('plants.create');

    Route::post('/dashboard/nurseries/show/{nursery}/plants', [PlantController::class, 'store'])
        ->name('plants.store');


    /*
    | Nursery wildcard (index / create) — must come LAST
    */
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


    /*
    | Logout
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

});