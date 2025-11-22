<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ReviewController;

// All user dashboard routes require authentication
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    
    // User Dashboard
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    
    // Bookings
    Route::get('/bookings', [ProfileController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [ProfileController::class, 'showBooking'])->name('bookings.show');
    
    // Favorites
    Route::get('/favorites', [ProfileController::class, 'favorites'])->name('favorites');
    Route::post('/favorites/{tour}', [ProfileController::class, 'addFavorite'])->name('favorites.add');
    Route::delete('/favorites/{favorite}', [ProfileController::class, 'removeFavorite'])->name('favorites.remove');
    
    // Create Booking
    Route::post('/bookings/create/{tour}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
    
    // Reviews
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
});