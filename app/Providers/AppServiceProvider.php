<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FertilizerAnalysisService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind FertilizerAnalysisService sebagai singleton
        $this->app->singleton(FertilizerAnalysisService::class, function ($app) {
            return new FertilizerAnalysisService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
