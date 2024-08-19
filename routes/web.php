<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyUserToken;
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

Route::get('/', function () {
    return view('welcome');
});



// ______ Phase 2_______

Route::get('/category', [CategoryController::class, 'index'])->middleware([VerifyUserToken::class]);
Route::get('/list-category', [CategoryController::class, 'showAllCategory'])->middleware([VerifyUserToken::class]);

Route::post('/create-category', [CategoryController::class, 'storeCategoryAction'])->middleware([VerifyUserToken::class]);
Route::post('/delete-category', [CategoryController::class, 'deleteCategoryAction'])->middleware([VerifyUserToken::class]);
Route::post('/category-by-id', [CategoryController::class, 'editCategoryAction'])->middleware([VerifyUserToken::class]);
Route::post('/update-category', [CategoryController::class, 'updateCategoryAction'])->middleware([VerifyUserToken::class]);





// ______ Phase 3 _______

Route::get('/customerPage', [CustomerController::class, 'index'])->middleware([VerifyUserToken::class]);
Route::get('/list-customer', [CustomerController::class, 'showAllCustomers'])->middleware([VerifyUserToken::class]);
Route::post('/customer-by-id', [CustomerController::class, 'editCustomerAction'])->middleware([VerifyUserToken::class]);
Route::post('/update-customer', [CustomerController::class, 'updateCustomerAction'])->middleware([VerifyUserToken::class]);
Route::post('/delete-customer', [CustomerController::class, 'deleteCustomerAction'])->middleware([VerifyUserToken::class]);

Route::post('/create-customer', [CustomerController::class, 'storeCustomerAction'])->middleware([VerifyUserToken::class]);






//  phase 1 routes


Route::get('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', [UserController::class, 'register']);
Route::get('/send-otp', [UserController::class, 'showSendOtpForm']);
Route::get('/verify-otp', [UserController::class, 'showVerifyOtpForm']);
Route::get('/reset-password', [UserController::class, 'showResetPasswordForm']);
Route::get('/profile', [UserController::class, 'showUserProfilePage'])->middleware([VerifyUserToken::class]);
Route::get('/user-profile', [UserController::class, 'showUserProfile'])->middleware([VerifyUserToken::class]);


Route::get('/dashboard', [UserController::class, 'showDashboard'])->middleware([VerifyUserToken::class]);



Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::post('/sent-otp', [UserController::class, 'sendOtp']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([VerifyUserToken::class]);
Route::post('/user-update', [UserController::class, 'userProfileUpdate'])->middleware([VerifyUserToken::class]);