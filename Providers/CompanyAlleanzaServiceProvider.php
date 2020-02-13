<?php

namespace Modules\CompanyAlleanza\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class CompanyAlleanzaServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('CompanyAlleanza', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('CompanyAlleanza', 'Config/config.php') => config_path('companyalleanza.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('CompanyAlleanza', 'Config/config.php'), 'companyalleanza'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/companyalleanza');

        $sourcePath = module_path('CompanyAlleanza', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/companyalleanza';
        }, \Config::get('view.paths')), [$sourcePath]), 'companyalleanza');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/companyalleanza');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'companyalleanza');
        } else {
            $this->loadTranslationsFrom(module_path('CompanyAlleanza', 'Resources/lang'), 'companyalleanza');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('CompanyAlleanza', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
