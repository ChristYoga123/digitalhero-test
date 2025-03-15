<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use App\Contracts\PaymentInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Services\MidtransPaymentService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentInterface::class, MidtransPaymentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.header', function ($view)
        {
            $view->with('menus', config('menus'));
        });
        // Blade Components
        Blade::include('components.footer', 'Footer');
        Blade::include('components.header', 'Header');
        Blade::include('components.preloader', 'Preloader');
        Blade::include('components.service-card', 'ServiceCard');
        Blade::include('components.title', 'Title');

        // Core Configurations
        Paginator::useBootstrapFive();
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());
        Date::use(CarbonImmutable::class);
        DB::prohibitDestructiveCommands(app()->isProduction());
    }
}
