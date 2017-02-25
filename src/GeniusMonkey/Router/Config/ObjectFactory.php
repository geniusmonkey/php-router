<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 2/24/17
 * Time: 9:49 PM
 */

namespace GeniusMonkey\Router\Config;


interface ObjectFactory
{

    /**
     * @param string $type Fully qualified class to instantiate
     * @return mixed A instance of the given $type
     */
    function instance($type);


}