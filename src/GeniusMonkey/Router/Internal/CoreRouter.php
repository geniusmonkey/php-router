<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 9/16/15
 * Time: 5:37 PM
 */

namespace GeniusMonkey\Router\Internal;


use GeniusMonkey\Router\Config\ObjectFactory;
use GeniusMonkey\Router\Filter\CoreFilterChain;
use GeniusMonkey\Router\Filter\Filter;
use GeniusMonkey\Router\Filter\FilterDefinition;
use GeniusMonkey\Router\Route\MatchContext;
use GeniusMonkey\Router\Route\PathDefinition;
use GeniusMonkey\Router\Route\Routable;
use GeniusMonkey\Router\Route\RouteDefinition;
use GeniusMonkey\Router\Route\RouteNotFoundException;
use GeniusMonkey\Router\RouteConfiguration;
use GeniusMonkey\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CoreRouter implements Router, Routable
{
    /** @var array */
    private $routeMethods = [];

    /** @var FilterDefinition[] */
    private $filters = [];

    /** @var RouteDefinition */
    private $defaultRoute = null;

    /** @var ObjectFactory */
    private $objectFactory;

    /**
     * CoreRouter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string|string[] $method
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handle($method, $path, $callable)
    {
        $methods = $method;
        if (!is_array($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            $this->addRoute($method, $path, $callable);
        }
    }

    public function handleGet($path, $callable)
    {
        $this->addRoute("GET", $path, $callable);
    }

    public function handlePost($path, $callable)
    {
        $this->addRoute("POST", $path, $callable);
    }

    public function handlePut($path, $callable)
    {
        $this->addRoute("PUT", $path, $callable);
    }

    public function handleDelete($path, $callable)
    {
        $this->addRoute("DELETE", $path, $callable);
    }

    public function handleAll($path, $callable)
    {
        $this->addAllRoutes($path, $callable);
    }

    public function filter($path, $filter)
    {
        $this->addFilter($path, $filter);
    }

    /**
     * @param callable|string $callable
     * @return void
     */
    public function handleDefault($callable)
    {
        $this->defaultRoute = new RouteDefinition("", $callable, false);
    }


    /**
     * @param string $path
     * @param RouteConfiguration|string $config
     * @return void
     */
    public function mount($path, $config)
    {
        $callable = function (Router $router) use ($config, $path) {
            $instant = $config;
            if (is_string($config)) {
                $instant = $this->objectFactory->instance($config);
            }

            if (!($config instanceof RouteConfiguration)) {
                throw new \InvalidArgumentException("In order to mount '$path' you must pass in a object or class that implements " . RouteConfiguration::class);
            }

            $instant->configRoutes($router);
        };
        $this->addAllRoutes($path, $callable, true);
    }

    private function addFilter($path, $filter)
    {
        array_push($this->filters, new FilterDefinition($path, $filter));
    }

    /**
     * @param string $path
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function filterAndRoute($path, $request)
    {
        if (!$this->endsWith($path, "/")) {
            $path .= '/';
        }


        $filters = $this->matchedFilters($path);
        $filterChain = new CoreFilterChain($filters);
        return $filterChain->startFilter($request, $this, $path);
    }

    /**
     * @param String $path
     * @param ServerRequestInterface $req
     * @return ResponseInterface|\Zend\Diactoros\Response
     * @throws RouteNotFoundException
     */
    public function route($path, $req)
    {
        if (!$this->endsWith($path, "/")) {
            $path .= '/';
        }

        $context = new MatchContext($path);
        $method = $req->getMethod();
        $route = null;

        if (array_key_exists($method, $this->routeMethods)) {
            /** @var PathDefinition $definition */
            foreach ($this->routeMethods[$method] as $definition) {
                if ($definition->matches($context)) {
                    $route = $definition;
                    break;
                }
            }
        }

        if ($route == null) {
            $route = $this->defaultRoute;
        }

        foreach ($context->getPathParameters() as $key => $value) {
            $req = $req->withAttribute($key, $value);
        }

        if ($route == null) {
            throw new RouteNotFoundException("Unable to find a route that matches path $path, and no default route set");
        }

        $callable = $route->getCallable();
        if ($route->isMount()) {
            $subRouter = new CoreRouter();
            $subRouter->objectFactory = $this->objectFactory;
            $callable($subRouter);
            $subPath = $context->getSubPath();
            return $subRouter->route($subPath, $req);
        } else {
            return $callable($req);
        }
    }

    /**
     * @param string $method
     * @param string $path
     * @param callable|string $callable
     * @param bool $isMount
     */
    private function addRoute($method, $path, $callable, $isMount = false)
    {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException("You must pass in a callable for $method:$path");
        }

        if (!array_key_exists($method, $this->routeMethods)) {
            $this->routeMethods[$method] = [];
        }

        $this->routeMethods[$method][] = new RouteDefinition($path, $callable, $isMount);
    }

    private function addAllRoutes($path, $callable, $mount = false)
    {
        $this->addRoute(Router::GET, $path, $callable, $mount);
        $this->addRoute(Router::PUT, $path, $callable, $mount);
        $this->addRoute(Router::POST, $path, $callable, $mount);
        $this->addRoute(Router::DELETE, $path, $callable, $mount);
    }

    /**
     * @return ObjectFactory
     */
    public function getObjectFactory()
    {
        return $this->objectFactory;
    }

    private function matchedFilters($path)
    {
        $filters = [];
        foreach ($this->filters as $definition) {
            $context = new MatchContext($path);
            if (!$definition->matches($context)) {
                continue;
            }

            $filter = $definition->getFilter();
            if (!is_object($filter)) {
                $filter = $this->objectFactory->instance($filter);

            }

            if ($filter instanceof Filter) {
                array_push($filters, $filter);
            } else {
                throw new \InvalidArgumentException("Can not add filter " . get_class($filter) . ", it must be of type " . Filter::class);
            }
        }
        return $filters;
    }

    private function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    private function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }
}