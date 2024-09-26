<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        // TODO: 目前欄位有很多不確定性，且系統暫時未上線，所以採用此寫法。後續應該要移除，避免 Mass Assignment 風險。
        Model::unguard();
    }
}
