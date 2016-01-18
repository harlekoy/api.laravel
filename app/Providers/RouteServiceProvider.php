<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'IdeaRobin\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
