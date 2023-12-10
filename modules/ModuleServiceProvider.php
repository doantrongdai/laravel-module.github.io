<?php

namespace Modules;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Modules\User\src\HTTP\Middlewares\DemoMiddleware;
use Modules\User\src\Commands\TestCommand;

class ModuleServiceProvider extends ServiceProvider
{
    private $middlewares = [
        'demo' => DemoMiddleware::class
    ];

    private $commands = [
        TestCommand::class

    ];

    public function boot()
    {
        $modules = $this->getModules();
        if (!empty($modules)) {
            foreach ($modules as $module) {
                $this->registerModule($module);
            }
        }
    }


    public function register()
    {

        //configs
        $modules = $this->getModules();
        if (!empty($modules)) {
            foreach ($modules as $module) {
                $this->registerConfig($module);
            }
        }


        // Middleware
        $this->registerMiddlewares();

        //commands
        $this->commands($this->commands);
    }

    //Load
    private function getModules()
    {
        $directories = array_map('basename', File::directories(__DIR__));
        return $directories;
    }

    // Register Module
    private function registerModule($module)
    {
        $modulePath = __DIR__ . "/{$module}";
        // echo $modulePath . '<br/>';

        //Khai báo Routes

        if (File::exists($modulePath . '/routes/routes.php')) {
            $this->loadRoutesFrom($modulePath . '/routes/routes.php');
        }

        //Khai báo migrations
        if (File::exists($modulePath . '/migrations.php')) {
            $this->loadMigrationsFrom($modulePath . '/migrations');
        }

        //Khai báo languages
        if (File::exists($modulePath . '/resources/lang')) {

            $this->loadTranslationsFrom($modulePath . '/resources/lang', $module);

            $this->loadJsonTranslationsFrom($modulePath . '/resources/lang');
        }

        //Khai báo views
        if (File::exists($modulePath . '/resources/views')) {
            $this->loadViewsFrom($modulePath . '/resources/views', $module);
        }

        //Khai báo helpers
        if (File::exists($modulePath . '/helpers')) {
            $helperList = File::allFiles($modulePath . '/helpers');
            if (!empty($helperList)) {
                foreach ($helperList as $helper) {
                    $file = $helper->getPathName();
                    require $file;
                }
            }
        }
    }

    // Register configs
    private function registerConfig($module)
    {
        $configPath = __DIR__ . '/' . $module . '/configs';
        if (File::exists($configPath)) {
            $configFiles = array_map('basename', File::allFiles($configPath));
            foreach ($configFiles as $config) {
                $alias = basename($config, '.php');
                // echo $alias . '<br/>';
                $this->mergeConfigFrom($configPath . '/' . $config, $alias);
            }
        }
    }

    // Register middlewares
    private function registerMiddlewares()
    {
        if (!empty($this->middlewares)) {
            foreach ($this->middlewares as $key => $middleware) {
                $this->app['router']->pushMiddlewareToGroup($key, $middleware);
            }
        }
    }
}