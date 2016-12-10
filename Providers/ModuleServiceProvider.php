<?php

namespace ProVision\Pages\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use ProVision\Pages\Administration;

class ModuleServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot() {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'pages');

        $this->publishes([
            __DIR__ . '/../Resources/Lang' => resource_path('lang/vendor/provision/pages'),
        ], 'lang');

        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'pages');

        $this->publishes([
            __DIR__ . '/../Resources/Views' => resource_path('views/vendor/provision/pages'),
        ], 'views');

        \ProVision\Administration\Administration::bootModule('pages', Administration::class);

    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register() {
        //$this->app->register(RouteServiceProvider::class);
    }
}
