<?php
namespace Uxx\Demo;
use Illuminate\Support\ServiceProvider;

class UxxServiceProvider extends ServiceProvider
{
    protected $commands = [
        Console\InstallCommand::class,
        Console\PublishCommand::class,
    ];
    protected $routeMiddleware = [
        'uxx.log'        => Middleware\LogOperation::class,
    ];
    protected $middlewareGroups = [];
    public function boot(){
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'uxx');
        $this->ensureHttps();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->registerPublishing();
    }
    public function register()
    {
        $this->loadUxxConfig();
        $this->registerRouteMiddleware();
        $this->commands($this->commands);    
    }
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'uxx-config');
            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'uxx-lang');
            $this->publishes([__DIR__.'/../resources/assets' => public_path('assets/uxx')], 'uxx-assets');
           // $this->publishes([__DIR__.'/../resources/dist' => public_path()], 'uxx-dist');
       }
    }
    protected function loadUxxConfig()
    {
     
    }
    /**
     * Force to set https scheme if https enabled.
     *
     * @return void
     */
    protected function ensureHttps()
    {
        if (config('uxx.https')) {
            url()->forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}