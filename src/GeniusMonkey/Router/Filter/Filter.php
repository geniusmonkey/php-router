<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:30 AM
 */

namespace GeniusMonkey\Router\Filter;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Filter
{
    /**
     * @param ServerRequestInterface $req
     * @param FilterChain $chain
     * @return null|ResponseInterface
     */
    public function filter(ServerRequestInterface $req, FilterChain $chain);
}