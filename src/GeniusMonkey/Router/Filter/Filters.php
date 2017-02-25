<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 10:54 AM
 */

namespace GeniusMonkey\Router\Filter;


use DI\Container;
use GeniusMonkey\Router\Filter\CoreFilterChain;
use GeniusMonkey\Router\Filter\Filter;
use GeniusMonkey\Router\Filter\FilterDefinition;
use GeniusMonkey\Router\Route\MatchContext;

class Filters
{

    /**
     * @param Filter[] $filters
     * @return FilterChain
     */
    public static function createChain($filters)
    {
        return new CoreFilterChain($filters);
    }
}