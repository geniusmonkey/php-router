<?php
use Mocks\MockFilter;
use PHPUnit\Framework\TestCase;


class FilterTest extends TestCase
{
    private $filter1;
    private $filter2;
    private $request;
    /** @var \GeniusMonkey\Router\Internal\CoreRouter router */
    private $router;

    protected function setUp()
    {
        $this->filter1 = new MockFilter();
        $this->filter2 = new MockFilter();
        $this->request = new \Zend\Diactoros\ServerRequest();
        $this->router = new \GeniusMonkey\Router\Internal\CoreRouter();
        $this->router->handleDefault(function(){});
    }

    public function testFilter()
    {
        $this->router->filter("/", $this->filter1);
        $this->router->filterAndRoute("/test", $this->request);

        self::assertTrue($this->filter1->called);
    }

    public function testMultipleFilters(){
        $this->router->filter("/", $this->filter1);
        $this->router->filter("/test", $this->filter2);
        $this->router->filterAndRoute("/test/deep/deeper", $this->request);

        self::assertTrue($this->filter1->called);
        self::assertTrue($this->filter2->called);
    }

    public function testFilterWithPathParam(){
        $this->router->filter("/", $this->filter1);
        $this->router->filter("/test/:id", $this->filter2);
        $this->router->filterAndRoute("/test/deep/deeper", $this->request);

        self::assertTrue($this->filter1->called);
        self::assertTrue($this->filter2->called);
    }
}
