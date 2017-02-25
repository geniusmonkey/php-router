<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 9/16/15
 * Time: 2:30 PM
 */

namespace GeniusMonkey\Router;


interface Router
{
    const GET = "GET";
    const PUT = "PUT";
    const POST = "POST";
    const DELETE = "DELETE";

    /**
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handleGet($path, $callable);
    /**
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handlePost($path, $callable);
    /**
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handlePut($path, $callable);
    /**
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handleDelete($path, $callable);
    /**
     * @param string $method
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handle($method, $path, $callable);
    /**
     * @param string $path
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handleAll($path, $callable);
    /**
     * @param string $path
     * @param string|RouteConfiguration $callable
     * @return mixed
     */
    public function mount($path, $callable);
    /**
     * @param callable|string|RouteConfiguration $callable
     * @return mixed
     */
    public function handleDefault($callable);

    /**
     * @param string $path
     * @param
     * @return mixed
     */
    public function filter($path, $callable);
}