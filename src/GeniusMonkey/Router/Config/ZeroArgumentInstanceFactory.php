<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 2/24/17
 * Time: 9:53 PM
 */

namespace GeniusMonkey\Router\Config;


class ZeroArgumentInstanceFactory implements ObjectFactory
{

    /**
     * @inheritdoc
     */
    function instance($type)
    {
        return new $type();
    }
}