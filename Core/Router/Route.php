<?php

namespace Core\Router;

class Route
{

    public static function Route()
    {

        $router = new Router;
        require 'Router/Routes.php';
        require 'Utils/utils.php';
        require 'App/Variables.php';        
        
        /**
         * Match the Requested Url
         */
        $url = rtrim(ltrim($_SERVER['QUERY_STRING']));
        $router->dispatch($url);
    }
}
