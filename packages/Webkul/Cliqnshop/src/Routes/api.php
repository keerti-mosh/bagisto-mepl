<?php

use Illuminate\Support\Facades\Route;
use Webkul\Cliqnshop\Http\Controllers\API\AddressController;
use Webkul\Cliqnshop\Http\Controllers\API\CartController;
use Webkul\Cliqnshop\Http\Controllers\API\CategoryController;
use Webkul\Cliqnshop\Http\Controllers\API\CompareController;
use Webkul\Cliqnshop\Http\Controllers\API\CoreController;
use Webkul\Cliqnshop\Http\Controllers\API\CustomerController;
use Webkul\Cliqnshop\Http\Controllers\API\OnepageController;
use Webkul\Cliqnshop\Http\Controllers\API\ProductController;
use Webkul\Cliqnshop\Http\Controllers\API\ReviewController;
use Webkul\Cliqnshop\Http\Controllers\API\WishlistController;

Route::group(['prefix' => 'api'], function () {
    Route::controller(CoreController::class)->prefix('core')->group(function () {
        Route::get('countries', 'getCountries')->name('cliqnshop.api.core.countries');

        Route::get('states', 'getStates')->name('cliqnshop.api.core.states');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('', 'index')->name('cliqnshop.api.categories.index');

        Route::get('tree', 'tree')->name('cliqnshop.api.categories.tree');

        Route::get('attributes', 'getAttributes')->name('cliqnshop.api.categories.attributes');

        Route::get('attributes/{attribute_id}/options', 'getAttributeOptions')->name('cliqnshop.api.categories.attribute_options');

        Route::get('max-price/{id?}', 'getProductMaxPrice')->name('cliqnshop.api.categories.max_price');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('cliqnshop.api.products.index');

        Route::get('{id}/related', 'relatedProducts')->name('cliqnshop.api.products.related.index');

        Route::get('{id}/up-sell', 'upSellProducts')->name('cliqnshop.api.products.up-sell.index');
    });

    Route::controller(ReviewController::class)->prefix('product/{id}')->group(function () {
        Route::get('reviews', 'index')->name('cliqnshop.api.products.reviews.index');

        Route::post('review', 'store')->name('cliqnshop.api.products.reviews.store');

        Route::get('reviews/{review_id}/translate', 'translate')->name('cliqnshop.api.products.reviews.translate');
    });

    Route::controller(CompareController::class)->prefix('compare-items')->group(function () {
        Route::get('', 'index')->name('cliqnshop.api.compare.index');

        Route::post('', 'store')->name('cliqnshop.api.compare.store');

        Route::delete('', 'destroy')->name('cliqnshop.api.compare.destroy');

        Route::delete('all', 'destroyAll')->name('cliqnshop.api.compare.destroy_all');
    });

    Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
        Route::get('', 'index')->name('cliqnshop.api.checkout.cart.index');

        Route::post('', 'store')->name('cliqnshop.api.checkout.cart.store');

        Route::put('', 'update')->name('cliqnshop.api.checkout.cart.update');

        Route::delete('', 'destroy')->name('cliqnshop.api.checkout.cart.destroy');

        Route::delete('selected', 'destroySelected')->name('cliqnshop.api.checkout.cart.destroy_selected');

        Route::post('move-to-wishlist', 'moveToWishlist')->name('cliqnshop.api.checkout.cart.move_to_wishlist');

        Route::post('coupon', 'storeCoupon')->name('cliqnshop.api.checkout.cart.coupon.apply');

        Route::post('estimate-shipping-methods', 'estimateShippingMethods')->name('cliqnshop.api.checkout.cart.estimate_shipping');

        Route::delete('coupon', 'destroyCoupon')->name('cliqnshop.api.checkout.cart.coupon.remove');

        Route::get('cross-sell', 'crossSellProducts')->name('cliqnshop.api.checkout.cart.cross-sell.index');
    });

    Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
        Route::get('summary', 'summary')->name('cliqnshop.checkout.onepage.summary');

        Route::post('addresses', 'storeAddress')->name('cliqnshop.checkout.onepage.addresses.store');

        Route::post('shipping-methods', 'storeShippingMethod')->name('cliqnshop.checkout.onepage.shipping_methods.store');

        Route::post('payment-methods', 'storePaymentMethod')->name('cliqnshop.checkout.onepage.payment_methods.store');

        Route::post('orders', 'storeOrder')->name('cliqnshop.checkout.onepage.orders.store');
    });

    /**
     * Login routes.
     */
    Route::controller(CustomerController::class)->prefix('customer')->group(function () {
        Route::post('login', 'login')->name('cliqnshop.api.customers.session.create');
    });

    Route::group(['middleware' => ['customer'], 'prefix' => 'customer'], function () {
        Route::controller(AddressController::class)->prefix('addresses')->group(function () {
            Route::get('', 'index')->name('cliqnshop.api.customers.account.addresses.index');

            Route::post('', 'store')->name('cliqnshop.api.customers.account.addresses.store');

            Route::put('edit/{id?}', 'update')->name('cliqnshop.api.customers.account.addresses.update');
        });

        Route::controller(WishlistController::class)->prefix('wishlist')->group(function () {
            Route::get('', 'index')->name('cliqnshop.api.customers.account.wishlist.index');

            Route::post('', 'store')->name('cliqnshop.api.customers.account.wishlist.store');

            Route::post('{id}/move-to-cart', 'moveToCart')->name('cliqnshop.api.customers.account.wishlist.move_to_cart');

            Route::delete('all', 'destroyAll')->name('cliqnshop.api.customers.account.wishlist.destroy_all');

            Route::delete('{id}', 'destroy')->name('cliqnshop.api.customers.account.wishlist.destroy');
        });
    });
});
