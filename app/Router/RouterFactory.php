<?php

namespace Chap\Router;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{
    /**
     * @return RouteList
     */
    public static function createRouter(): RouteList
    {
        $router = new RouteList;
        $router[] = new Route('administrator/<presenter>/<action>[/<id>]',
            ['module' => 'Admin', 'presenter' => 'Admin', 'action' => 'default']);

        $router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        return $router;
    }
}
