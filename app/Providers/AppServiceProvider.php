<?php

namespace App\Providers;

use App\Services\Center\AdminService;
use App\Services\Api\ArticleService;
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
        $this->app->singleton('ArticleService',function ($app){
            return $app->make(ArticleService::class);
        });
        $this->app->singleton('AdminService',function ($app){
            return $app->make(AdminService::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
