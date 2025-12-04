<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register the Filament panel provider so Filament has a default panel.
        if (class_exists(\App\Providers\FilamentServiceProvider::class)) {
            $this->app->register(\App\Providers\FilamentServiceProvider::class);
        }
    }

    public function boot(): void
    {
        //
    }
}
