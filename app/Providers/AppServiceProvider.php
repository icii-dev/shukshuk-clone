<?php

namespace App\Providers;

use App\Http\Resources\UserAddressResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //check env before send email
        if (!app()->isProduction()) {
            Mail::alwaysTo('tintran.uit@gmail.com');
        }
        Schema::defaultStringLength(191);
        UserAddressResource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing', 'dev', 'indo-prod')) {
            $this->app->register(DuskServiceProvider::class);
        }


    }
}
