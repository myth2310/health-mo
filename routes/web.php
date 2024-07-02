<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\CheckingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\HistoryController;
use App\Http\Controllers\Dashboard\TryController;
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
Route::get('/coba', [DashboardController::class, 'coba']);
Route::get('/fetch-data', [DashboardController::class, 'fetchData']);

Route::group(['middleware' => ['auth', 'ceklevel:Admin,User']], function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile/update', [DashboardController::class, 'update'])->name('profile.update');
    Route::get('/checking', [CheckingController::class, 'index'])->name('checking');
    Route::get('/hasil-rekomendasi', [CheckingController::class, 'rekomendasi']);
});
Route::group(['middleware' => ['auth', 'ceklevel:Admin']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/activasi/{id}', [UserController::class, 'sendMail']);
    Route::get('/hapus-user/{id}', [UserController::class, 'hapus']);
    Route::get('/history', [HistoryController::class, 'index'])->name('admin.history');
    Route::post('/search-user', [HistoryController::class, 'searchUser']);
    Route::post('/get-user-details', [HistoryController::class, 'getUserDetails']);
    Route::get('/hapus-health/{id}', [HistoryController::class, 'hapus']);
    Route::post('/insert-health-data', [CheckingController::class, 'store']);
    Route::get('/health/data', [CheckingController::class, 'getHealthData']);
    Route::post('/store/data', [CheckingController::class, 'Healthstore']);
});

Route::group(['middleware' => ['auth', 'ceklevel:User']], function () {
    Route::get('/history-checking', [HistoryController::class, 'history'])->name('user.history');
});

Route::get('/try-view', [TryController::class, 'index']);
Route::post('/start-data-collection', [TryController::class, 'startDataCollection']);
Route::post('/post-data', [TryController::class, 'storeHealthData']);
Route::get('/get-data/{userId}', [TryController::class, 'getHealthData']);



