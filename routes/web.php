<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MyRegistrationController;

// ==== USER SIDE (Public) ====
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/acara', [EventController::class, 'index'])->name('events.index');
Route::get('/acara/{event}', [EventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    Route::get('/acara/{event}/daftar', [EventController::class, 'registerForm'])->name('events.register');
    Route::post('/acara/{event}/daftar', [EventController::class, 'registerStore'])->name('events.register.store');
    Route::post('/kupon/cek', [EventController::class, 'checkCoupon'])->name('coupon.check');
});

// ==== USER SIDE (Authenticated) ====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home'); // user biasa tetap ke beranda
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/sertifikat/{registration}', [CertificateController::class, 'download'])->name('certificate.download');
    Route::get('/pendaftaran-saya', [MyRegistrationController::class, 'index'])->name('registrations.index');
});

// ==== ADMIN SIDE ====
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ParticipantController as AdminParticipantController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventCategoryController as AdminEventCategoryController;
use App\Http\Controllers\Admin\EventCityController as AdminEventCityController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::resource('events', AdminEventController::class);
    Route::get('/participants', [AdminParticipantController::class, 'index'])->name('participants.index');
    Route::resource('coupons', AdminCouponController::class)->except(['create', 'edit', 'show']);
    Route::resource('users', AdminUserController::class)->only(['index', 'destroy']);

    // Master Data
    Route::resource('event-categories', AdminEventCategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('event-cities', AdminEventCityController::class)->except(['show', 'create', 'edit']);
});
require __DIR__.'/auth.php';