<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');



// ______ Phase 2 category _______

Route::get('/category', [CategoryController::class, 'index'])->middleware(['jwtverified']);
Route::get('/list-category', [CategoryController::class, 'showAllCategory'])->middleware(['jwtverified']);

Route::post('/create-category', [CategoryController::class, 'storeCategoryAction'])->middleware(['jwtverified']);
Route::post('/delete-category', [CategoryController::class, 'deleteCategoryAction'])->middleware(['jwtverified']);
Route::post('/category-by-id', [CategoryController::class, 'editCategoryAction'])->middleware(['jwtverified']);
Route::post('/update-category', [CategoryController::class, 'updateCategoryAction'])->middleware(['jwtverified']);





// ______ Phase 3 customers _______

Route::get('/customerPage', [CustomerController::class, 'index'])->middleware(['jwtverified'])->name('customer');
Route::get('/list-customer', [CustomerController::class, 'showAllCustomers'])->middleware(['jwtverified']);
Route::post('/customer-by-id', [CustomerController::class, 'editCustomerAction'])->middleware(['jwtverified']);
Route::post('/update-customer', [CustomerController::class, 'updateCustomerAction'])->middleware(['jwtverified']);
Route::post('/delete-customer', [CustomerController::class, 'deleteCustomerAction'])->middleware(['jwtverified']);

Route::post('/create-customer', [CustomerController::class, 'storeCustomerAction'])->middleware(['jwtverified']);




// ______ Phase 4 products _______


Route::get('/productPage', [ProductController::class, 'index'])->middleware(['jwtverified']);
Route::get('/list-product', [ProductController::class, 'showAllProducts'])->middleware(['jwtverified']);
Route::post('/create-product', [ProductController::class, 'storeProduct'])->middleware(['jwtverified']);
Route::post('/product-by-id', [ProductController::class, 'editProduct'])->middleware(['jwtverified']);
Route::post('/update-product', [ProductController::class, 'updateProduct'])->middleware(['jwtverified']);
Route::post('/delete-product', [ProductController::class, 'deleteProduct'])->middleware(['jwtverified']);





// ______ Phase 5 invoice _______
Route::get('/invoicePage', [InvoiceController::class, 'index'])->middleware(['jwtverified']);
Route::get('/invoice-select', [InvoiceController::class, 'getAllInvoice'])->middleware(['jwtverified']);
Route::get('/salePage', [InvoiceController::class, 'SalePage'])->middleware(['jwtverified']);

Route::post('/invoice-create', [InvoiceController::class, 'invoiceCreate'])->middleware(['jwtverified']);
Route::post('/invoice-delete', [InvoiceController::class, 'invoiceDelete'])->middleware(['jwtverified']);
Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware(['jwtverified']);





//  phase 1 routes


Route::get('/login', [UserController::class, 'login'])->name('login.form');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/user-registration', [UserController::class, 'userRegistration']);

Route::get('/send-otp', [UserController::class, 'showSendOtpForm']);
Route::post('/sent-otp', [UserController::class, 'sendOtp']);

Route::get('/verify-otp', [UserController::class, 'showVerifyOtpForm']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);


Route::get('/reset-password', [UserController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware(['jwtverified']);

Route::get('/profile', [UserController::class, 'showUserProfilePage'])->middleware(['jwtverified']);
Route::get('/user-profile', [UserController::class, 'showUserProfile'])->middleware(['jwtverified']);
Route::post('/user-update', [UserController::class, 'userProfileUpdate'])->middleware(['jwtverified']);





// dashborad 

Route::group(['middleware' => 'jwtverified'], function() {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard']);
    Route::get('/summary', [DashboardController::class, 'summary']);
    Route::get('/reportPage', [ReportController::class, 'ReportPage']);
    Route::get('/sales-report/{fromDate}/{toDate}', [ReportController::class, 'salesReport']);
});




