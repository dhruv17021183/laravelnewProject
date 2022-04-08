<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();
        Blade::aliasComponent('components.badge','badge');
        Blade::aliasComponent('components.update','update');
        Blade::aliasComponent('components.errors','errors');
        Blade::aliasComponent('components.tag','tag');

    }
}
