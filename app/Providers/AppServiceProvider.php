<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        if (config('app.env') === 'production' || config('app.env') === 'staging') {
//            URL::forceScheme('https');
//        }

        view()->composer('*', function ($view) {
            $is_app = false;
            $request = $this->app->request;
            $ua = $request->server('HTTP_USER_AGENT');
            if ($ua === config('const.app_ua')) {
                $is_app = true;
            }
            $view->with('is_app', $is_app);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            // Print SQL Log
            \DB::listen(function ($query) {
                $sql = $query->sql;
                for ($i = 0; $i < count($query->bindings); $i++) {
                    $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
                }

                \Log::debug("SQL", ["time" => sprintf("%.2f ms", $query->time), "sql" => $sql]);
            });
        }
    }
}
