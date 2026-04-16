<?php

namespace App\Providers;

use App\Services\CurrencyService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CurrencyService::class);
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $currency = session('currency', 'IDR');
            $view->with('currentCurrency', $currency);
            $view->with('currency', app(CurrencyService::class));
        });
    }
}
