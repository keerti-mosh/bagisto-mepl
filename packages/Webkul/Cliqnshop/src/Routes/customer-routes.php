<?php

use Illuminate\Support\Facades\Route;
use Webkul\Core\Http\Middleware\NoCacheMiddleware;
use Webkul\Cliqnshop\Http\Controllers\Customer\Account\AddressController;
use Webkul\Cliqnshop\Http\Controllers\Customer\Account\DownloadableProductController;
use Webkul\Cliqnshop\Http\Controllers\Customer\Account\OrderController;
use Webkul\Cliqnshop\Http\Controllers\Customer\Account\WishlistController;
use Webkul\Cliqnshop\Http\Controllers\Customer\CustomerController;
use Webkul\Cliqnshop\Http\Controllers\Customer\ForgotPasswordController;
use Webkul\Cliqnshop\Http\Controllers\Customer\GDPRController;
use Webkul\Cliqnshop\Http\Controllers\Customer\RegistrationController;
use Webkul\Cliqnshop\Http\Controllers\Customer\ResetPasswordController;
use Webkul\Cliqnshop\Http\Controllers\Customer\SessionController;
use Webkul\Cliqnshop\Http\Controllers\DataGridController;

Route::prefix('customer')->group(function () {
    /**
     * Forgot password routes.
     */
    Route::controller(ForgotPasswordController::class)->prefix('forgot-password')->group(function () {
        Route::get('', 'create')->name('cliqnshop.customers.forgot_password.create');

        Route::post('', 'store')->name('cliqnshop.customers.forgot_password.store');
    });

    /**
     * Reset password routes.
     */
    Route::controller(ResetPasswordController::class)->prefix('reset-password')->group(function () {
        Route::get('{token}', 'create')->name('cliqnshop.customers.reset_password.create');

        Route::post('', 'store')->name('cliqnshop.customers.reset_password.store');
    });

    /**
     * Login routes.
     */
    Route::controller(SessionController::class)->prefix('login')->group(function () {
        Route::get('', 'index')->name('cliqnshop.customer.session.index');

        Route::post('', 'store')->name('cliqnshop.customer.session.create');
    });

    /**
     * Registration routes.
     */
    Route::controller(RegistrationController::class)->group(function () {
        Route::prefix('register')->group(function () {
            Route::get('', 'index')->name('cliqnshop.customers.register.index');

            Route::post('', 'store')->name('cliqnshop.customers.register.store');
        });

        /**
         * Customer verification routes.
         */
        Route::get('verify-account/{token}', 'verifyAccount')->name('cliqnshop.customers.verify');

        Route::get('resend/verification/{email}', 'resendVerificationEmail')->name('cliqnshop.customers.resend.verification_email');
    });

    /**
     * Customer authenticated routes. All the below routes only be accessible
     * if customer is authenticated.
     */
    Route::group(['middleware' => ['customer', NoCacheMiddleware::class]], function () {
        /**
         * Datagrid routes.
         */
        Route::get('datagrid/look-up', [DataGridController::class, 'lookUp'])->name('cliqnshop.customer.datagrid.look_up');

        /**
         * Logout.
         */
        Route::delete('logout', [SessionController::class, 'destroy'])->name('cliqnshop.customer.session.destroy');

        /**
         * Customer account. All the below routes are related to
         * customer account details.
         */
        Route::prefix('account')->group(function () {
            Route::get('', [CustomerController::class, 'account'])->name('cliqnshop.customers.account.index');

            /**
             * Wishlist.
             */
            Route::get('wishlist', [WishlistController::class, 'index'])->name('cliqnshop.customers.account.wishlist.index');

            /**
             * Profile.
             */
            Route::controller(CustomerController::class)->group(function () {
                Route::prefix('profile')->group(function () {
                    Route::get('', 'index')->name('cliqnshop.customers.account.profile.index');

                    Route::get('edit', 'edit')->name('cliqnshop.customers.account.profile.edit');

                    Route::post('edit', 'update')->name('cliqnshop.customers.account.profile.update');

                    Route::post('destroy', 'destroy')->name('cliqnshop.customers.account.profile.destroy');
                });

                Route::get('reviews', 'reviews')->name('cliqnshop.customers.account.reviews.index');
            });

            /**
             * GDPR.
             */
            Route::controller(GDPRController::class)->prefix('gdpr')->group(function () {
                Route::get('', 'index')->name('cliqnshop.customers.account.gdpr.index');

                Route::post('', 'store')->name('cliqnshop.customers.account.gdpr.store');

                Route::get('pdf-view', 'pdfView')->name('cliqnshop.customers.account.gdpr.pdf-view');

                Route::get('html-view', 'htmlView')->name('cliqnshop.customers.account.gdpr.html-view');

                Route::get('revoke/{id}', 'revoke')->name('cliqnshop.customers.account.gdpr.revoke');
            });

            /**
             * Cookie consent.
             */
            Route::get('your-cookie-consent-preferences', [GDPRController::class, 'cookieConsent'])
                ->name('cliqnshop.customers.gdpr.cookie-consent');

            /**
             * Addresses.
             */
            Route::controller(AddressController::class)->prefix('addresses')->group(function () {
                Route::get('', 'index')->name('cliqnshop.customers.account.addresses.index');

                Route::get('create', 'create')->name('cliqnshop.customers.account.addresses.create');

                Route::post('create', 'store')->name('cliqnshop.customers.account.addresses.store');

                Route::get('edit/{id}', 'edit')->name('cliqnshop.customers.account.addresses.edit');

                Route::put('edit/{id}', 'update')->name('cliqnshop.customers.account.addresses.update');

                Route::patch('edit/{id}', 'makeDefault')->name('cliqnshop.customers.account.addresses.update.default');

                Route::delete('delete/{id}', 'destroy')->name('cliqnshop.customers.account.addresses.delete');
            });

            /**
             * Orders.
             */
            Route::controller(OrderController::class)->prefix('orders')->group(function () {
                Route::get('', 'index')->name('cliqnshop.customers.account.orders.index');

                Route::get('view/{id}', 'view')->name('cliqnshop.customers.account.orders.view');

                Route::get('reorder/{id}', 'reorder')->name('cliqnshop.customers.account.orders.reorder');

                Route::post('cancel/{id}', 'cancel')->name('cliqnshop.customers.account.orders.cancel');

                Route::get('print/Invoice/{id}', 'printInvoice')->name('cliqnshop.customers.account.orders.print-invoice');
            });

            /**
             * Downloadable products.
             */
            Route::controller(DownloadableProductController::class)->prefix('downloadable-products')->group(function () {
                Route::get('', 'index')->name('cliqnshop.customers.account.downloadable_products.index');

                Route::get('download/{id}', 'download')->name('cliqnshop.customers.account.downloadable_products.download');
            });
        });
    });
});
