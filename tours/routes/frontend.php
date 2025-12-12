<?php
// routes/frontend.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\ReviewController;

/*
|--------------------------------------------------------------------------
| Frontend Authenticated Routes
|--------------------------------------------------------------------------
| All routes require user authentication
*/

Route::middleware(['auth', 'user'])->group(function () {
    
    // Profile
    Route::get('/profile/dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Bookings
    Route::get('/profile/bookings', [BookingController::class, 'index'])->name('profile.bookings');
    Route::get('/profile/bookings/{booking}', [BookingController::class, 'show'])->name('profile.bookings.show');
    Route::get('/bookings/create/{tour}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
    Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Payment Routes
    Route::post('/payment/initiate/{booking}', [BookingController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/esewa/success', [BookingController::class, 'esewaSuccess'])->name('payment.esewa.success');
    Route::get('/payment/esewa/failure', [BookingController::class, 'esewaFailure'])->name('payment.esewa.failure');
    Route::post('/payment/khalti/verify', [BookingController::class, 'verifyKhaltiPayment'])->name('payment.khalti.verify');
    
    // Favorites
    Route::get('/profile/favorites', [FavoriteController::class, 'index'])->name('profile.favorites');
    Route::post('/favorites/toggle/{tour}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    
    // Reviews
    Route::post('/tours/{tour}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
});