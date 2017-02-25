<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:57 AM
 */

namespace GeniusMonkey\Router\Filter;


use GeniusMonkey\Router\Route\Routable;
use Psr\Http\Message\ServerRequestInterface;

interface Chainable
{

    public function startFilter(ServerRequestInterface $req, Routable $router, $path);
}