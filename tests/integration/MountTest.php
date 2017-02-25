<?php
use PHPUnit\Framework\TestCase;

class MountTest extends TestCase
{
    /** @var \GeniusMonkey\Router\Internal\CoreRouter router */
    private $router;
    private $controller;

    protected function setUp()
    {
        $this->controller = new \Mocks\MockMountController();
        $this->router = new \GeniusMonkey\Router\Internal\CoreRouter();
        $this->router->handleDefault(function(){});
    }

    public function testMountAndRoute()
    {
        $request = new \Zend\Diactoros\ServerRequest([], [], null, "GET");

        $this->router->mount("/widgets", $this->controller);
        $response = $this->router->filterAndRoute("/widgets/123", $request);

        self::assertInstanceOf(\Mocks\MockResponse::class, $response);
    }
}