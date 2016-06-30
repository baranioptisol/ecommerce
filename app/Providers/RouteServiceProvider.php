<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Dingo\Api\Routing\Router as ApiRouter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $siteNamespace = 'App\Http\Controllers\Site';

    protected $adminNamespace = 'App\Http\Controllers\Admin';

    protected $apiNamespace = 'App\Http\Controllers\Api';
   

    /**
     * This version is applied to the API routes in your routes file.
     *
     * Check dingo/api's documentation for more info.
     *
     * @var string
     */
    protected $version = 'v1';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
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
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router, ApiRouter $apiRouter)
    {
        $this->mapWebRoutes($router, $apiRouter);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router, ApiRouter $apiRouter)
    {
         /*
        |--------------------------------------------------------------------------
        | Router 
        |--------------------------------------------------------------------------
        */

        $router->group(['namespace' => $this->namespace, 'middleware' => 'web',], function ($router) {
            require app_path('Http/routes.php');
        });

        /*
        |--------------------------------------------------------------------------
        | Site Router 
        |--------------------------------------------------------------------------
        */

        $router->group(['namespace' => $this->siteNamespace], function ($router) {
            require app_path('Http/Routes/routes.site.php');
        });

        /*
        |--------------------------------------------------------------------------
        | Admin Router 
        |--------------------------------------------------------------------------
        */

        $router->group(['namespace' => $this->adminNamespace], function ($router) {
            require app_path('Http/Routes/routes.admin.php');
        });

        /*
        |--------------------------------------------------------------------------
        | Api Router 
        |--------------------------------------------------------------------------
        */

        $apiRouter->version($this->version, function ($apiRouter) use ($router) {
           $apiRouter->group(['namespace' => $this->apiNamespace], function ($api) use ($router) {
               $router->group(['namespace' => $this->apiNamespace], function ($router) use ($api) {
                   require app_path('Http/Routes/routes.api.php');
               });
           });
        });
    }
}