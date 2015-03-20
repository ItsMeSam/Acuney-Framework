<?php

include "app/bootstrap.php";

use Acuney\Router\RouteGroup;
use Acuney\Router\Route;
use Acuney\Router\Router;


$routegroup = new RouteGroup();

$routegroup->attach(
	new Route(
		"/home",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController",
			"_view"			=> "homeView"
		)
	)
);

$routegroup->attach(
	new Route(
		"/",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController",
			"_view"			=> "homeView"
		)
	)
);

$routegroup->attach(
	new Route(
		"/error",
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
	$router->draw($_SERVER['REQUEST_URI']);
	echo $router->run();
}
else
{
	$router->draw("/error");
	$router->controller->setError(404);
	echo $router->run();
}