<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// Authentication Routes - Protected from authenticated users
Route::middleware(['guest:web', 'disable.auth.cache'])->group(function () {
    // Login Routes
    Route::get('login', fn() => view('auth.login'))->name('login');
    Route::post('login', function () {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, request()->boolean('remember'))) {
            // Regenerate session after successful login
            request()->session()->regenerate();
            return redirect()->intended('medical-records');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    })->name('login');

    // Registration Routes
    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

// Authenticated Routes - Protected from guests with no-cache headers
Route::middleware(['auth:web', 'prevent.back.logout'])->group(function () {
    // Logout Route
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        // Add headers to prevent back button after logout
        return redirect('/')->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
                           ->header('Pragma', 'no-cache')
                           ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
    })->name('logout');

    // Medical Records Routes
    Route::resource('medical-records', MedicalRecordController::class);
});

// Home Route
Route::get('/', function () {
    return Auth::check() ? redirect()->route('medical-records.index') : redirect()->route('login');
});