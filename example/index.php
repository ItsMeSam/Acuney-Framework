<?php

include "app/bootstrap.php";

use Acuney\Router\RouteGroup;
use Acuney\Router\Route;
use Acuney\Router\Router;


$routegroup = new RouteGroup();

$routegroup->attach(
	new Route(
		"/Acuney-Framework/example/home",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController",
			"_view"			=> "homeView"
		)
	)
);

$routegroup->attach(
	new Route(
		"/Acuney-Framework/example/",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController",
			"_view"			=> "homeView"
		)
	)
);

$routegroup->attach(
	new Route(
		"/Acuney-Framework/example/error",
		array(
			"_model"		=> "errorModel",
			"_controller"	=> "errorController",
			"_view"			=> "errorView"
		)
	)
);

$router = new Router($routegroup);

if ( $router->matchCurrent() )
{
	$router->draw($router->current());
	echo $router->run();
}
else
{
	header("HTTP/1.0 404 Not Found");
	$router->draw("/Acuney-Framework/example/error");
	$router->controller->setError(404);
	echo $router->run();
}