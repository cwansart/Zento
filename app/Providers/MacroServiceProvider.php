<?php

namespace Zento\Providers;

use Illuminate\Support\ServiceProvider;
use HTML;
use Request;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        HTML::macro('isActive', function($name)
        {
            if(Request::path() == '/' && $name == 'users') return 'active';
            return Request::is($name) ? 'active' : '';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
