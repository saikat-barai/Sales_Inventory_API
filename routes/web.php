<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user_registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user_login');