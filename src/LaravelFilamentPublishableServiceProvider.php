<?php

namespace Novius\LaravelFilamentPublishable;

use Illuminate\Support\ServiceProvider;

class LaravelFilamentPublishableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'laravel-filament-publishable');

        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/laravel-filament-publishable'),
        ], 'lang');
    }
}
