<?php


namespace GeniusMonkey\Router\Internal;


use GeniusMonkey\Router\Builder\RouterBuilder;
use GeniusMonkey\Router\Config\ObjectFactory;
use GeniusMonkey\Router\Config\ZeroArgumentInstanceFactory;

class RouteBuilderImpl implements RouterBuilder
{

    private $objectFactory = null;

    /**
     * @inheritdoc
     */
    function objectFactory(ObjectFactory $factory)
    {
        $this->objectFactory = $factory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    function build()
    {
        $router = new CoreRouter();
        $router->setObjectFactory($this->objectFactory == null ? new ZeroArgumentInstanceFactory() : $this->objectFactory);
    }
}