<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cliqnshop\Http\Controllers\BookingProductController;
use Webkul\Cliqnshop\Http\Controllers\CompareController;
use Webkul\Cliqnshop\Http\Controllers\HomeController;
use Webkul\Cliqnshop\Http\Controllers\PageController;
use Webkul\Cliqnshop\Http\Controllers\ProductController;
use Webkul\Cliqnshop\Http\Controllers\ProductsCategoriesProxyController;
use Webkul\Cliqnshop\Http\Controllers\SearchController;
use Webkul\Cliqnshop\Http\Controllers\SubscriptionController;

/**
 * CMS pages.
 */
Route::get('page/{slug}', [PageController::class, 'view'])
    ->name('cliqnshop.cms.page')
    ->middleware('cache.response');

/**
 * Fallback route.
 */
Route::fallback(ProductsCategoriesProxyController::class . '@index')
    ->name('cliqnshop.product_or_category.index')
    ->middleware('cache.response');

/**
 * Store front home.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('cliqnshop.home.index')
    ->middleware('cache.response');

Route::get('contact-us', [HomeController::class, 'contactUs'])
    ->name('cliqnshop.home.contact_us')
    ->middleware('cache.response');

Route::post('contact-us/send-mail', [HomeController::class, 'sendContactUsMail'])
    ->name('cliqnshop.home.contact_us.send_mail')
    ->middleware('cache.response');

/**
 * Store front search.
 */
Route::get('search', [SearchController::class, 'index'])
    ->name('cliqnshop.search.index')
    ->middleware('cache.response');

Route::post('search/upload', [SearchController::class, 'upload'])->name('cliqnshop.search.upload');

/**
 * Subscription routes.
 */
Route::controller(SubscriptionController::class)->group(function () {
    Route::post('subscription', 'store')->name('cliqnshop.subscription.store');

    Route::get('subscription/{token}', 'destroy')->name('cliqnshop.subscription.destroy');
});

/**
 * Compare products
 */
Route::get('compare', [CompareController::class, 'index'])
    ->name('cliqnshop.compare.index')
    ->middleware('cache.response');

/**
 * Downloadable products
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('downloadable/download-sample/{type}/{id}', 'downloadSample')->name('cliqnshop.downloadable.download_sample');

    Route::get('product/{id}/{attribute_id}', 'download')->name('cliqnshop.product.file.download');
});

/**
 * Booking products
 */
Route::get('booking-slots/{id}', [BookingProductController::class, 'index'])
    ->name('cliqnshop.booking-product.slots.index');
