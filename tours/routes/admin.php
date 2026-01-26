<?php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes require authentication and admin role
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Tours
    Route::resource('tours', TourController::class)->names([
        'index' => 'admin.tours.index',
        'create' => 'admin.tours.create',
        'store' => 'admin.tours.store',
        'show' => 'admin.tours.show',
        'edit' => 'admin.tours.edit',
        'update' => 'admin.tours.update',
        'destroy' => 'admin.tours.destroy',
    ]);
    
    // Bookings
    Route::resource('bookings', BookingController::class)->names([
        'index'   => 'admin.bookings.index',
        'create'  => 'admin.bookings.create', 
        'store'   => 'admin.bookings.store',   
        'show'    => 'admin.bookings.show',
        'edit'    => 'admin.bookings.edit',
        'update'  => 'admin.bookings.update',
        'destroy' => 'admin.bookings.destroy', 
    ]);
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('admin.bookings.confirm');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('admin.bookings.cancel');
    
    // Users
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // Categories
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    
    // Destinations
    Route::resource('destinations', DestinationController::class)->names([
        'index' => 'admin.destinations.index',
        'create' => 'admin.destinations.create',
        'store' => 'admin.destinations.store',
        'show' => 'admin.destinations.show',
        'edit' => 'admin.destinations.edit',
        'update' => 'admin.destinations.update',
        'destroy' => 'admin.destinations.destroy',
    ]);
    
    // Blogs
    Route::resource('blogs', BlogController::class)->names([
        'index' => 'admin.blogs.index',
        'create' => 'admin.blogs.create',
        'store' => 'admin.blogs.store',
        'show' => 'admin.blogs.show',
        'edit' => 'admin.blogs.edit',
        'update' => 'admin.blogs.update',
        'destroy' => 'admin.blogs.destroy',
    ]);
    
    // Reviews
    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('admin.reviews.show');
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('admin.reviews.reject');
    Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('admin.reviews.reply');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    
    // Inquiries
    Route::get('inquiries', [InquiryController::class, 'index'])->name('admin.inquiries.index');
    Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('admin.inquiries.show');
    Route::post('inquiries/{inquiry}/reply', [InquiryController::class, 'reply'])->name('admin.inquiries.reply');
    Route::post('inquiries/{inquiry}/close', [InquiryController::class, 'close'])->name('admin.inquiries.close');
    Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('admin.inquiries.destroy');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');
    
});