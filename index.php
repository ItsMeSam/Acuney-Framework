<?php

include "app/routes.php";

use Acuney\Router\RouteGroup;
use Acuney\Router\Route;
use Acuney\Router\Router;

$router = new Router($routegroup);
$router->setErrorHandler($errorroute);

if ( $router->matchCurrent() )
{
	$router->draw($router->current());
	echo $router->run();
}
else
{
	echo $router->handleError("404 Not Found");
}
