<?php

namespace Webkul\Cliqnshop\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\Core\Http\Middleware\PreventRequestsDuringMaintenance;
use Webkul\Cliqnshop\Http\Middleware\AuthenticateCustomer;
use Webkul\Cliqnshop\Http\Middleware\CacheResponse;
use Webkul\Cliqnshop\Http\Middleware\Currency;
use Webkul\Cliqnshop\Http\Middleware\Locale;
use Webkul\Cliqnshop\Http\Middleware\Theme;

class CliqnshopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        $router->middlewareGroup('cliqnshop', [
            Theme::class,
            Locale::class,
            Currency::class,
        ]);

        $router->aliasMiddleware('theme', Theme::class);
        $router->aliasMiddleware('locale', Locale::class);
        $router->aliasMiddleware('currency', Currency::class);
        $router->aliasMiddleware('cache.response', CacheResponse::class);
        $router->aliasMiddleware('customer', AuthenticateCustomer::class);

        Route::middleware(['web', 'cliqnshop', PreventRequestsDuringMaintenance::class])->group(__DIR__ . '/../Routes/web.php');
        Route::middleware(['web', 'cliqnshop', PreventRequestsDuringMaintenance::class])->group(__DIR__ . '/../Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'cliqnshop');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'cliqnshop');

        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('themes/cliqnshop/views'),
        ]);

        Paginator::defaultView('cliqnshop::partials.pagination');
        Paginator::defaultSimpleView('cliqnshop::partials.pagination');

        Blade::anonymousComponentPath(__DIR__ . '/../Resources/views/components', 'cliqnshop');

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php',
            'menu.customer'
        );
    }
}
