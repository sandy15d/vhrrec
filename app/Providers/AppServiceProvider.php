<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use LivewireUI\Spotlight\Commands\Logout;
use LivewireUI\Spotlight\Spotlight;

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


       Spotlight::registerCommandIf(Auth::check() && Auth::user()->role == 'A',Logout::class);
    }
}
