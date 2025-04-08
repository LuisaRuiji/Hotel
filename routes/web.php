<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Commented out the original /dashboard route
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // New routes for different dashboards
    Route::get('/dashboard', function () {
        return view('dashboards.customer');
    })->name('dashboard'); // Define the named route here

    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    });

    Route::get('/reception/dashboard', function () {
        return view('dashboards.reception');
    });
});

require __DIR__.'/auth.php';