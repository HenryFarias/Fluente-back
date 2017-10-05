<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // É necessário cadatrar cada model no configApplication
        $models = Config::get('configApplication.models');


        if (!empty($models)) {
            foreach ($models as $model) {
                $this->app->bind("App\\Repositories\\{$model}Repository", "App\\Repositories\\{$model}RepositoryEloquent");
            }
        }
    }
}
