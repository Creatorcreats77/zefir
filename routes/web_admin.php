<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->group(function () {
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store']);

        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);
    });

Route::middleware('auth')
    ->group(function () {
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    });

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('banners', BannerController::class)->except('show');
        Route::resource('products', ProductController::class)->except('show');

        Route::middleware(IsAdminMiddleware::class)
            ->group(function () {
                Route::resource('genders', GenderController::class)->only('index');
                Route::resource('categories', CategoryController::class)->only('index');
                Route::resource('brands', BrandController::class)->only('index');
                Route::resource('attributes', AttributeController::class)->only('index');
                Route::resource('attributeValues', AttributeValueController::class)->only('index');
                Route::resource('variants', VariantController::class)->only('index');
                Route::resource('users', UserController::class)->only('index');
            });
    });
