<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ExtendStayController;
use App\Http\Controllers\ReceptionistController;

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

    // Customer routes
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/service-request', [ServiceRequestController::class, 'index'])->name('customer.service-request');
    Route::post('/service-request', [ServiceRequestController::class, 'store'])->name('customer.service-request.store');
    Route::get('/extend-stay', [ExtendStayController::class, 'index'])->name('customer.extend-stay');
    Route::post('/extend-stay', [ExtendStayController::class, 'store'])->name('customer.extend-stay.store');
    Route::get('/book-room/{room}', [RoomController::class, 'bookingForm'])->name('customer.book-room');
    Route::post('/book-room/{room}', [RoomController::class, 'processBooking'])->name('customer.book-room.store');
    Route::get('/bookings/{booking}/confirmation', [RoomController::class, 'confirmation'])->name('bookings.confirmation');

    // Admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/receptionist', [AdminController::class, 'receptionist'])->name('admin.receptionist');
    Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');

    // Receptionist Routes
    Route::prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
        Route::get('/checkin', [ReceptionistController::class, 'checkin'])->name('checkin');
        Route::post('/checkin/process', [ReceptionistController::class, 'processCheckin'])->name('process-checkin');
        Route::post('/checkout/process', [ReceptionistController::class, 'processCheckout'])->name('process-checkout');
        Route::get('/checkout', [ReceptionistController::class, 'checkout'])->name('checkout');
        Route::get('/rooms', [ReceptionistController::class, 'rooms'])->name('rooms');
        Route::get('/bookings/create', [ReceptionistController::class, 'createBooking'])->name('bookings.create');
        Route::get('/bookings/{id}', [ReceptionistController::class, 'viewBooking'])->name('bookings.view');
        Route::post('/bookings/{id}/approve', [ReceptionistController::class, 'approveBooking'])->name('bookings.approve');
        Route::post('/bookings/{id}/reject', [ReceptionistController::class, 'rejectBooking'])->name('bookings.reject');
        Route::get('/bookings/{id}/payment', [ReceptionistController::class, 'showPayment'])->name('bookings.payment');
        Route::post('/bookings/{id}/payment', [ReceptionistController::class, 'processPayment'])->name('bookings.process-payment');
    });
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
Route::get('/admin/receptionist', [AdminController::class, 'receptionist'])->name('admin.receptionist');
Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');

require __DIR__.'/auth.php';