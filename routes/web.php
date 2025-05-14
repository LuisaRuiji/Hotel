<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/book', [RoomController::class, 'bookingForm'])->name('rooms.book');
Route::post('/rooms/{room}/book', [RoomController::class, 'processBooking'])
    ->middleware('auth')
    ->name('rooms.process-booking');

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

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
Route::get('/admin/receptionist', [AdminController::class, 'receptionist'])->name('admin.receptionist');
Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');

require __DIR__.'/auth.php';