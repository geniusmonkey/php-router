<?php
/**
 * Created by IntelliJ IDEA.
 * User: patrick
 * Date: 11/13/15
 * Time: 11:03 AM
 */

namespace GeniusMonkey\Router\Route;


use GeniusMonkey\Router\Route\MatchContext;

class PathDefinition
{

    /** @var  String */
    private $path;

    /** @var  String[] */
    private $pathParts;

    /**
     * @return String
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param String $path
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->pathParts = explode('/', ltrim(rtrim($path, '/'), '/'));
    }

    public function matches(MatchContext $context)
    {
        $requestedParts = $context->getPathParts();
        $routeParts = $this->pathParts;

        if(sizeof($routeParts) == 1 && $routeParts[0] === ""){
            return $context->matched(true);
        }

        if(count($requestedParts) < count($routeParts)){
            return $context->matched(false);
        }


        $pathParams = [];
        for($i = 0; $i < count($this->pathParts); $i++){
            $requestPart = $requestedParts[$i];
            $routePart = $routeParts[$i];
            if($this->startsWith($routePart, ':')){
                $key = substr($routePart, 1);
                $pathParams[$key] = $requestPart;
            } elseif ($requestPart != $routePart) {
                return $context->matched(false);
            }
        }

        $subPathParts = [];
        for($i = count($routeParts); $i < count($requestedParts); $i++){
            array_push($subPathParts, $requestedParts[$i]);
        }

        $context->setMatched(true);
        $context->setPathParameters($pathParams);
        $context->setSubPath(implode("/", $subPathParts));
        return $context->isMatched();
    }

    protected function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    protected function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

}