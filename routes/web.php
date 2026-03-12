<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\NurseryController;
use App\Http\Controllers\PlantController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EsewaController;
use App\Models\Nursery;

// Helper to return partial or full view depending on request type
function dashboardView(string $page, array $data = [])
{
    $data['nursery'] = $data['nursery'] ?? Auth::user()->nursery;
    $data['user']    = $data['user']    ?? Auth::user();

    if (request()->header('X-Dashboard-Navigate')) {
        return view('pages.dashboard.' . $page, $data);
    }

    return view('pages.dashboard.sidebar', array_merge($data, ['page' => $page]));
}

// Public Routes
Route::get('/', function (){
    $nurseries = Nursery::with('plants')->get();
    return view('login', compact('nurseries'));
})->name('login');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Protected Routes
Route::middleware('auth')->group(function () {

    // Verify
    Route::get('/dashboard/verify', [ProfileController::class, 'verify'])->name('verify');
    Route::post('/dashboard/verify', [ProfileController::class, 'storeVerification'])->name('verify.store');

    // Nursery show
    Route::get('/dashboard/nurseries/show', function () {
        $nursery = Auth::user()->nursery;
        if (!$nursery) {
            return redirect()->route('nurseries.create')
                ->with('error', 'You do not have a nursery yet.');
        }
        return dashboardView('nurseries.nursery', ['nursery' => $nursery->load('plants')]);
    })->name('nursery.show');

    // Nursery create
    Route::get('/dashboard/nurseries/create', [NurseryController::class, 'create'])->name('nurseries.create');
    Route::post('/dashboard/nurseries', [NurseryController::class, 'store'])->name('dashboard.nurseries.store');

    // Plants
    Route::get('/dashboard/nurseries/plants/create', [PlantController::class, 'create'])->name('plants.create');
    Route::post('/dashboard/nurseries/plants', [PlantController::class, 'store'])->name('plants.store');

    // File viewing
    Route::get('/file/{filename}', function ($filename) {
        $userId = Auth::id();
        $path = $userId . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($path));
    })->name('file.view');

    // Settings
    Route::get('/dashboard/settings', function () {
        return dashboardView('settings');
    })->name('settings');

    Route::get('/dashboard/settings/editProfile', [ProfileController::class, 'edit'])->name('editProfile');
    Route::post('/dashboard/settings/editProfile', [ProfileController::class, 'update'])->name('editProfile.update');

    Route::get('/dashboard/settings/security', function () {
        return dashboardView('settings.security');
    })->name('security');

    Route::get('/dashboard/settings/security/loginhistory', function () {
        return dashboardView('settings.security.loginHistory');
    })->name('settings.loginHistory');

    Route::get('/dashboard/settings/purchasehistory', function () {
        return dashboardView('settings.purchaseHistory');
    })->name('purchaseHistory');

    // Subscription
    Route::get('/dashboard/payment/subscription', function () {
        return dashboardView('payment.subscription');
    })->name('subscription');

    //eSewa Routes
    Route::post('/esewa/initiate', [EsewaController::class, 'initiate'])->name('esewa.initiate');
    Route::get('/esewa/verify',   [EsewaController::class, 'verify'])->name('esewa.verify');

    // Dashboard wildcard LAST
    Route::get('/dashboard/{page?}', function ($page = 'dashboard') {
        return dashboardView($page);
    })->name('dashboard');

    Route::get('/dashboard/payment/checkout', function () {
        $plan = request('plan', 'biennial');
        return dashboardView('payment.checkout', ['plan' => $plan]);
    })->name('checkout');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
