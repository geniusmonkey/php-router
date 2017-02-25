<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 2/24/17
 * Time: 9:46 PM
 */

namespace GeniusMonkey\Router\Builder;


use GeniusMonkey\Router\Config\ObjectFactory;

interface RouterBuilder
{

    function objectFactor(ObjectFactory $factory);

}