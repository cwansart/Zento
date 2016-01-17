<?php

namespace Zento\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('required_train_select', function($attribute, $value, $parameters, $validator) {
            if(empty($validator->getData()['train']))
            {
                return true;
            } else {
                return ($value >= 0 && $value <= 3);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
