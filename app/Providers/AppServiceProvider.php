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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            // Fetch all active ads from DB and group them by position
            // Since this runs on every view render, we might cache it in production,
            // but for now directly fetching works as expected.
            try {
                $ads = \App\Models\Advertisement::where('is_active', true)->get()->groupBy('position');
            } catch (\Exception $e) {
                $ads = collect(); // Table might not exist yet during initial migrate
            }
            $view->with('globalAds', $ads);
        });
    }
}
