<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Generic Dashboard Redirection
Route::get('/dashboard', function () {
    if (auth()->user()->isSuperAdmin()) {
        return redirect()->route('super_admin.dashboard');
    }
    return redirect()->route('gym.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/subscription-expired', function () {
    return view('subscription_expired');
})->name('subscription.expired');

require __DIR__.'/auth.php';
