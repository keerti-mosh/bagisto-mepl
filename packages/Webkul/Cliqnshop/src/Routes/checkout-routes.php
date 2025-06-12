<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cliqnshop\Http\Controllers\CartController;
use Webkul\Cliqnshop\Http\Controllers\OnepageController;

/**
 * Cart routes.
 */
Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
    Route::get('', 'index')->name('cliqnshop.checkout.cart.index');
});

Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
    Route::get('', 'index')->name('cliqnshop.checkout.onepage.index');

    Route::get('success', 'success')->name('cliqnshop.checkout.onepage.success');
});
