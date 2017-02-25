<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:55 AM
 */

namespace GeniusMonkey\Router\Filter;


use GeniusMonkey\Router\Route\Routable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CoreFilterChain implements FilterChain, Chainable
{
    /**
     * @var Filter[]
     */
    private $filters;
    /**
     * @var int
     */
    private $index = -1;

    /**
     * @var Routable;
     */
    private $router;
    /**
     * @var string
     */
    private $path;

    /**
     * CoreFilterChain constructor.
     * @param Filter[] $filters
     */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @param ServerRequestInterface $req
     * @return ResponseInterface
     */
    public function doNext(ServerRequestInterface $req)
    {
        $this->index++;
        if(isset($this->filters[$this->index])){
            $filter = $this->filters[$this->index];
            return $filter->filter($req, $this);
        } else {
            return $this->router->route($this->path, $req);
        }
    }


    /**
     * @param ServerRequestInterface $req
     * @param Routable $router
     * @param string $path
     * @return ResponseInterface
     */
    public function startFilter(ServerRequestInterface $req, Routable $router, $path)
    {
        $this->path = $path;
        $this->router = $router;
        return $this->doNext($req);
    }
}