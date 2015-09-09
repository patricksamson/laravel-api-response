<?php
namespace Lykegenes\ApiResponse;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/config.php';
        $this->mergeConfigFrom($configPath, 'api-response');

        /*$this->app->bindShared('datagrid-builder', function ($app) {

    return new DatagridBuilder($app, $app['datagrid-helper']);
    });*/
    }

    public function boot()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return ['api-response'];
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('api-response.php');
    }

}
