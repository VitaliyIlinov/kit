<?php

namespace App\Providers;

use App\Models\Symbol;
use App\Models\UserLink;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
//        Route::bind('send_currency', function (string $value) {
//            return SymbolInfo::where('code', $value)->firstOrFail();
//        });
//        Route::bind('receive_currency', function (string $value) {
//            return SymbolInfo::where('code', $value)->firstOrFail();
//        });
    }
}
