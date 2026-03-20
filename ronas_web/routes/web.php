<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/captcha', function () {
    return response()->json(['captcha' => captcha_img('math')]);
})->name('captcha');
Route::middleware(['guest'])->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users/add', [UsersController::class, 'store'])->name('users.add');
    Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
    Route::post('/users/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset_password');
    Route::post('/users/delete', [UsersController::class, 'destroy'])->name('users.delete');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});