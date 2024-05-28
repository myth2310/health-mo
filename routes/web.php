<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\CheckingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\HistoryController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/sign-in', [AuthController::class, 'index'])->name('sign-in');
Route::get('/sign-up', [AuthController::class, 'registrasi']);
Route::get('/sign-in/identify', [AuthController::class, 'checkEmail']);
Route::post('/check-email', [AuthController::class, 'checkEmailAndRedirect'])->name('check-email');

Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/store', [AuthController::class, 'create'])->name('register.user');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth', 'ceklevel:Admin,User']], function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::post('/profile/update', [DashboardController::class, 'update'])->name('profile.update');
    Route::get('/users-per-month', [DashboardController::class, 'getUsersPerMonthData']);
   
});
Route::group(['middleware' => ['auth', 'ceklevel:Admin']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/activasi/{id}', [UserController::class, 'sendMail']);
    Route::get('/hapus-user/{id}', [UserController::class, 'hapus']);
    Route::get('/history', [HistoryController::class, 'index'])->name('admin.history');
});

Route::group(['middleware' => ['auth', 'ceklevel:User']], function () {
    Route::get('/history-checking', [HistoryController::class, 'history'])->name('user.history');
    Route::get('/checking', [CheckingController::class, 'index']);
    Route::get('/health/data', [CheckingController::class, 'getHealthData']);
    Route::post('/health/store', [CheckingController::class, 'storeHealthData']);

});
