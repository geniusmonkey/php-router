<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:42 AM
 */

namespace GeniusMonkey\Router\Filter;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface FilterChain
{

    /**
     * @param ServerRequestInterface $req
     * @return ResponseInterface
     */
    public function doNext(ServerRequestInterface $req);
}