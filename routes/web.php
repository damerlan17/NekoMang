<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;

// Общедоступные маршруты

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Маршруты для гостей

Route::middleware('guest')->group(function () {

    // Регистрация

    Route::get('/register', [
        RegisterController::class,
        'create',
    ])->name('register');

    Route::post('/register', [
        RegisterController::class,
        'store',
    ])->middleware('throttle:10,1')
        ->name('register.store');

    // Авторизация

    Route::get('/login', [
        LoginController::class,
        'create',
    ])->name('login');

    Route::post('/login', [
        LoginController::class,
        'store',
    ])->name('login.store');

    // Восстановление пароля

    Route::get('/forgot-password', [
        ForgotPasswordController::class,
        'create',
    ])->name('password.request');

    Route::post('/forgot-password', [
        ForgotPasswordController::class,
        'store',
    ])->middleware('throttle:5,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [
        ResetPasswordController::class,
        'create',
    ])->name('password.reset');

    Route::post('/reset-password', [
        ResetPasswordController::class,
        'store',
    ])->middleware('throttle:5,1')
        ->name('password.update');

});

// Маршруты авторизованных пользователей

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'index',
    ])->name('profile.index');

    Route::post('/logout', [
        LogoutController::class,
        'destroy',
    ])->name('logout');

});

// Маршруты администратора

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [
            DashboardController::class,
            'index',
        ])->name('dashboard');

    });
