<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) {
            return new \App\CustomValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register services.
     */
    public function register()
    {
        //
    }
}
