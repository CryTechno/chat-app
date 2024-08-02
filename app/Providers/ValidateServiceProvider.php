<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidateServiceProvider extends ServiceProvider
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
        Validator::extend('name', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        Validator::replacer('name', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });

        Validator::extend('required_room_name', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

    }
}
