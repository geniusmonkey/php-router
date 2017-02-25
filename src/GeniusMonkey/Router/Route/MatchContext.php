<?php

namespace GeniusMonkey\Router\Route;


class MatchContext
{

    /** @var  bool */
    private $matched;
    /** @var  string[] */
    private $pathParameters = [];
    /** @var array[string]  */
    private $pathParts;
    /** @var string */
    private $subPath;

    /**
     * MatchContext constructor.
     */
    public function __construct($path)
    {
        $this->pathParts = explode('/', ltrim(rtrim($path, '/'), '/'));
    }

    /**
     * @return boolean
     */
    public function isMatched()
    {
        return $this->matched;
    }

    /**
     * @param boolean $matched
     * @return bool
     */
    public function setMatched($matched)
    {
        $this->matched = $matched;
    }

    /**
     * @param $matched
     * @return boolean
     */
    public function matched($matched)
    {
        $this->matched = true;
        return $matched;
    }

    /**
     * @return \string[]
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }

    /**
     * @param \String[] $pathParameters
     */
    public function setPathParameters($pathParameters)
    {
        $this->pathParameters = $pathParameters;
    }

    /**
     * @return array[string]
     */
    public function getPathParts()
    {
        return $this->pathParts;
    }


    /**
     * @return string
     */
    public function getSubPath()
    {
        return $this->subPath;
    }

    /**
     * @param string $subPath
     */
    public function setSubPath($subPath)
    {
        $this->subPath = $subPath;
    }


}