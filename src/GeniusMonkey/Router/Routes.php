<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 9/17/15
 * Time: 8:23 AM
 */

namespace GeniusMonkey\Router;


use GeniusMonkey\Router\Builder\RouterBuilder;
use GeniusMonkey\Router\Internal\CoreRouter;
use GeniusMonkey\Router\Internal\RouteBuilderImpl;

class Routes
{

    public static function create(RouteConfiguration $rootConfig = null)
    {
        $router = new CoreRouter();
        if($rootConfig != null){
            $rootConfig->configRoutes($router);
        }
        return $router;
    }

    /**
     * @return RouterBuilder
     */
    public static function builder(){
        return new RouteBuilderImpl();
    }
}