<?php

namespace App\Providers;


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


    //   Spotlight::registerCommandIf(Auth::check() && Auth::user()->role == 'A',Logout::class);
    }
}
