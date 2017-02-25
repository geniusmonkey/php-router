<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 9/16/15
 * Time: 5:38 PM
 */

namespace GeniusMonkey\Router;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Routable
{
    /**
     * @param String $path
     * @param RequestInterface $req
     */
    public function route($path, $req);
}