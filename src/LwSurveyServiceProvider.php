<?php

namespace VictorYoalli\LwSurvey;

use Illuminate\Support\ServiceProvider;

class LwSurveyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'lw-survey');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lw-survey');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('lw-survey.php'),
            ], ['config', 'lw-survey']);

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/lw-survey'),
            ], ['views', 'lw-survey']);

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], ['migrations', 'lw-survey']);

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/lw-survey'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/lw-survey'),
            ], ['lang', 'lw-survey']);

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'lw-survey');

        // Register the main class to use with the facade
        $this->app->singleton('lw-survey', function () {
            return new LwSurvey;
        });
    }
}
