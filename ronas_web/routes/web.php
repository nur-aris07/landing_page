<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/captcha', function () {
    return response()->json(['captcha' => captcha_img('math')]);
})->name('captcha');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function() {
});
Route::middleware(['auth'])->group(function() {
});