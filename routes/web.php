<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user_registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user_login');
Route::get('/user-logout', [UserController::class, 'logout'])->name('user_logout');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify_otp');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset_password')->middleware(TokenVerificationMiddleware::class);


// category route 
Route::get('/category-list', [CategoryController::class, 'categoryList'])->name('category_list')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-create', [CategoryController::class, 'categoryCreate'])->name('category_create')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->name('category_delete')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-by-id', [CategoryController::class, 'categoryById'])->name('category_by_id')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->name('category_update')->middleware(TokenVerificationMiddleware::class);


// customer route 
