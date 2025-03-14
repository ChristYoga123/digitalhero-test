<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade Components
        Blade::include('components.footer', 'Footer');
        Blade::include('components.header', 'Header');
        Blade::include('components.preloader', 'Preloader');
        Blade::include('components.service-card', 'ServiceCard');

        // Core Configurations
        Paginator::useBootstrapFive();
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());
        Date::use(CarbonImmutable::class);
        DB::prohibitDestructiveCommands(app()->isProduction());
    }
}
