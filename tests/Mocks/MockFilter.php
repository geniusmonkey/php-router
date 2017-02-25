<?php


namespace Mocks;


use GeniusMonkey\Router\Filter\Filter;
use GeniusMonkey\Router\Filter\FilterChain;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MockFilter implements Filter
{

    /** @var boolean */
    public $called = false;
    /** @var boolean */
    public $caughtException = false;

    /**
     * @param ServerRequestInterface $req
     * @param FilterChain $chain
     * @return null|ResponseInterface
     */
    public function filter(ServerRequestInterface $req, FilterChain $chain)
    {
        $this->called = true;
        try {
            $chain->doNext($req);
        } catch (\Exception $e) {
            $this->caughtException = false;
        }
    }
}