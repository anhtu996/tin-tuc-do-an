<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'client.layout.header',
            'App\Http\ViewComposers\MenuComposer'
        );

        view()->composer(
            ['client.layout.left_sidebar_home', 'client.layout.left_sidebar_single'], 'App\Http\ViewComposers\SidebarComposer'
        );
        // view()->composer(
        //     ['client.pages.product_type','client.pages.search'],
        //     'App\Http\ViewComposers\LeftMenuComposer'
        // );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
