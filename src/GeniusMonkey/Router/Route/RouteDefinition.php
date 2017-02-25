<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 9/17/15
 * Time: 8:27 AM
 */

namespace GeniusMonkey\Router\Route;


use GeniusMonkey\Router\Route\PathDefinition;

class RouteDefinition extends PathDefinition
{


    /**
     * @var callable
     */
    private $callable;

    /**
     * @var boolean
     */
    private $mount = false;

    /**
     * RouteDefinition constructor.
     * @param String $path
     * @param callable $callable
     * @param bool $mount
     */
    public function __construct($path, callable $callable, $mount)
    {
        $this->setPath($path);
        $this->callable = $callable;
        $this->mount = $mount;
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @param callable $callable
     */
    public function setCallable($callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return boolean
     */
    public function isMount()
    {
        return $this->mount;
    }

    /**
     * @param boolean $mount
     */
    public function setMount($mount)
    {
        $this->mount = $mount;
    }
}