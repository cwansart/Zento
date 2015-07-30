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
            return ((preg_match('/^'.$name.'/', Request::path())) || (Request::path() == '/' && $name == 'users')) ? 'active' : '';
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
