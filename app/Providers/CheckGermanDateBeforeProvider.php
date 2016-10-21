<?php

namespace Zento\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Validator;

class CheckGermanDateBeforeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_before', function($attribute, $value, $parameters, $validator) {
            $regex = '/\d{2}\.\d{2}\.\d{4}( \d{2}:\d{2})?/';
            if(!preg_match($regex, $validator->getData()[$parameters[0]]))
            {
                return false;
            }
            if(strpos($value, ' '))
            {
                $start = Carbon::createFromFormat('d.m.Y H:i', $value);
            } else {
                $start = Carbon::createFromFormat('d.m.Y', $value);
            }

            if(strpos($validator->getData()[$parameters[0]], ' '))
            {
                $end = Carbon::createFromFormat('d.m.Y H:i', $validator->getData()[$parameters[0]]);
            } else {
                $end = Carbon::createFromFormat('d.m.Y', $validator->getData()[$parameters[0]]);
            }

            return $start <= $end;
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
