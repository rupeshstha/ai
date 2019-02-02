<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\App::make('files')->link(storage_path('app/public'), '../public_html/storage');
        //\App::make('files')->link(storage_path('app/public'), public_path('storage'));
        // Fix for Column length too long.
        \Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
