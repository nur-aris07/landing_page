<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CatalogSpecController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServiceSpecController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/temp', [IndexController::class, 'temp'])->name('temp');
Route::get('/captcha', function () {
    return response()->json(['captcha' => captcha_img('math')]);
})->name('captcha');
Route::middleware(['guest'])->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
    Route::post('/services/add', [ServicesController::class, 'store'])->name('services.add');
    Route::post('/services/update', [ServicesController::class, 'update'])->name('services.update');
    Route::post('/services/delete', [ServicesController::class, 'destroy'])->name('services.delete');
    Route::get('/services/{service}/specs', [ServiceSpecController::class, 'index'])->name('services.specs');
    Route::post('/services/specs/add', [ServiceSpecController::class, 'store'])->name('specs.add');
    Route::post('/services/specs/update', [ServiceSpecController::class, 'update'])->name('specs.update');
    Route::post('/services/specs/delete', [ServiceSpecController::class, 'destroy'])->name('specs.delete');
    Route::get('/services/{service}/specs/order-items', [ServiceSpecController::class, 'getDataOrder'])->name('specs.order-items');
    Route::post('/services/specs/reorder', [ServiceSpecController::class, 'reorder'])->name('specs.reorder');
    
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::post('/catalogs/add', [CatalogController::class, 'store'])->name('catalogs.add');
    Route::post('/catalogs/update', [CatalogController::class, 'update'])->name('catalogs.update');
    Route::post('/catalogs/delete', [CatalogController::class, 'destroy'])->name('catalogs.delete');
    Route::get('/catalogs/{catalog}/specs', [CatalogSpecController::class, 'index'])->name('catalogs.specs.index');
    Route::post('/catalogs/{catalog}/specs/add', [CatalogSpecController::class, 'store'])->name('catalogs.specs.add');
    
    Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');
    Route::post('/testimoni/add', [TestimoniController::class, 'store'])->name('testimoni.add');
    Route::post('/testimoni/update', [TestimoniController::class, 'update'])->name('testimoni.update');
    Route::post('/testimoni/delete', [TestimoniController::class, 'destroy'])->name('testimoni.delete');
    
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users/add', [UsersController::class, 'store'])->name('users.add');
    Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
    Route::post('/users/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset_password');
    Route::post('/users/delete', [UsersController::class, 'destroy'])->name('users.delete');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/add', [SettingsController::class, 'store'])->name('settings.add');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/delete', [SettingsController::class, 'destroy'])->name('settings.delete');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});