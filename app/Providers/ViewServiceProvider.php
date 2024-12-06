<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'layouts.admin.include.sidebar',
        ], function ($view) {
            $profile = \App\Models\Profile::first();
            $information = \App\Models\Information::first();

            return $view->with([
                'profile' => $profile,
                'information' => $information,
            ]);
        });
    }
}
