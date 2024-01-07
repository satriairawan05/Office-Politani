<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Unguard
        \Illuminate\Database\Eloquent\Model::unguard();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Locale
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');

        // Pagination
        \Illuminate\Pagination\Paginator::useBootstrapFour();
    }
}
