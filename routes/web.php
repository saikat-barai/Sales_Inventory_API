<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/user/login', [UserController::class, 'userLoginPage'])->name('user_login_page');
Route::get('/user/register', [UserController::class, 'userRegisterPage'])->name('user_register_page');
Route::get('/sendOtp', [UserController::class, 'sendOtpPage'])->name('send_otp_page');
Route::get('/verifyOtp', [UserController::class, 'verifyOtpPage'])->name('verify_otp_page');


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(TokenVerificationMiddleware::class);


// user route
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user_registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user_login');
Route::get('/user-logout', [UserController::class, 'logout'])->name('user_logout');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/sent-otp', [UserController::class, 'sentOtp'])->name('sent_otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify_otp');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset_password')->middleware(TokenVerificationMiddleware::class);
Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user_profile')->middleware(TokenVerificationMiddleware::class);
Route::post('/user-profile-update', [UserController::class, 'userProfileUpdate'])->name('user_profile_update')->middleware(TokenVerificationMiddleware::class);


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
Route::get('/invoice-select', [InvoiceController::class, 'invoiceSelect'])->name('invoice_select')->middleware(TokenVerificationMiddleware::class);
Route::post('/invoice-detalis', [InvoiceController::class, 'invoiceDetails'])->name('invoice_detalis')->middleware(TokenVerificationMiddleware::class);
Route::post('/invoice-delete', [InvoiceController::class, 'invoiceDelete'])->name('invoice_delete')->middleware(TokenVerificationMiddleware::class);


// dashboard summary 
Route::get('/dashboard-summary', [DashboardController::class, 'dashboardSummary'])->name('dashboard_summary')->middleware(TokenVerificationMiddleware::class);


// report route 
Route::get('/sale-report', [ReportController::class, 'saleReport'])->name('sale_report')->middleware(TokenVerificationMiddleware::class);