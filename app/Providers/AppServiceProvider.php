<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Prevent lazy loading, but only when the app is not in production.
        Model::preventLazyLoading(! $this->app->isProduction());

        // Prevent accessing missing attributes
        Model::preventsAccessingMissingAttributes();
        $this->app['request']->server->set('HTTPS','on');
        URL::forceScheme('https');
    }
}
