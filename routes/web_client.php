<?php

use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)
    ->group(function () {
        var_dump(1);
        Route::get('', 'index')->name('home');
        Route::get('locale/{locale}', 'locale')->name('locale')->where('locale', '[a-z]+');
    });

Route::controller(ProductController::class)
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        var_dump(2);
        Route::get('', 'index')->name('index');
        Route::get('/{slug}', 'show')->name('show')->where('slug', '[a-z0-9-]+');
    });

Route::controller(BrandController::class)
    ->prefix('brands')
    ->name('brands.')
    ->group(function () {
        Route::get('', 'index')->name('index');
    });
