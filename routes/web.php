<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user_registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user_login');
Route::get('/user-logout', [UserController::class, 'logout'])->name('user_logout');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify_otp');