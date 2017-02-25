<?php


namespace Mocks;


use GeniusMonkey\Router\RouteConfiguration;
use GeniusMonkey\Router\Router;

class MockMountController implements RouteConfiguration
{


    function configRoutes(Router $router)
    {
        $router->handleGet("/:id", function($request){
            return new MockResponse();
        });
    }
}