<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:26 AM
 */

namespace GeniusMonkey\Router\Filter;


use GeniusMonkey\Router\Filter\Filter;
use GeniusMonkey\Router\Route\PathDefinition;

class FilterDefinition extends PathDefinition
{

    /** @var Filter|string */
    private $filter;

    /**
     * FilterDefinition constructor.
     * @param string $path
     * @param Filter|string $filter
     */
    public function __construct($path, $filter)
    {
        $this->filter = $filter;
        $this->setPath($path);
    }

    /**
     * @return Filter|string
     */
    public function getFilter()
    {
        return $this->filter;
    }
}