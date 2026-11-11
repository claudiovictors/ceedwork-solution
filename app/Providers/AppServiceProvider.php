<?php

namespace App\Providers;

// use Illuminate\Support\Facades\URL;
use App\View\Composers\SiteComposer;
use Illuminate\Support\Facades\View;
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
        View::share('data', site_images());

        View::composer(
            ['layouts.main', 'components.*', 'pages.*'],
            SiteComposer::class
        );

        /*if (app()->environment('local')) {
            URL::forceScheme('https');
        }*/
    }
}
