<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// user route
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
Route::post('/category-by-id', [CategoryController::class, 'categoryById'])->name('category_by_id')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->name('category_update')->middleware(TokenVerificationMiddleware::class);
Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->name('category_delete')->middleware(TokenVerificationMiddleware::class);


// customer route 
Route::get('/customer-list', [CustomerController::class, 'customerList'])->name('customer_list')->middleware(TokenVerificationMiddleware::class);
Route::post('/customer-create', [CustomerController::class, 'customerCreate'])->name('customer_create')->middleware(TokenVerificationMiddleware::class);
Route::post('/customer-by-id', [CustomerController::class, 'customerById'])->name('customer_by_id')->middleware(TokenVerificationMiddleware::class);
Route::post('/customer-update', [CustomerController::class, 'customerUpdate'])->name('customer_update')->middleware(TokenVerificationMiddleware::class);
Route::post('/customer-delete', [CustomerController::class, 'customerDelete'])->name('customer_delete')->middleware(TokenVerificationMiddleware::class);


// product route 
Route::get('/product-list', [ProductController::class, 'productList'])->name('product_list')->middleware(TokenVerificationMiddleware::class);
Route::post('/product-create', [ProductController::class, 'productCreate'])->name('product_create')->middleware(TokenVerificationMiddleware::class);
Route::post('/product-by-id', [ProductController::class, 'productById'])->name('product_by_id')->middleware(TokenVerificationMiddleware::class);
Route::post('/product-update', [ProductController::class, 'productUpdate'])->name('product_update')->middleware(TokenVerificationMiddleware::class);
Route::post('/product-delete', [ProductController::class, 'productDelete'])->name('product_delete')->middleware(TokenVerificationMiddleware::class);


// invoice route 
Route::post('/invoice-create', [InvoiceController::class, 'invoiceCreate'])->name('invoice_create')->middleware(TokenVerificationMiddleware::class);