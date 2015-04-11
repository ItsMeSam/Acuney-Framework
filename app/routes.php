<?php

/*
* -------------------------
* | Routes                |
* -------------------------
* | In this file, you can |
* | create routes using   |
* | the Route and Route-  |
* | group class.          |
* -------------------------
*/


include "bootstrap.php";

use Acuney\Router\Route;
use Acuney\Router\RouteGroup;

$routegroup = new RouteGroup();

$routegroup->attach(
	new Route(
		"/Acuney-Framework/home",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController"
		)
	)
);

$routegroup->attach(
	new Route(
		"/Acuney-Framework/",
		array(
			"_model"		=> "homeModel",
			"_controller"	=> "homeController"
		)
	)
);

$errorroute = new Route(
	"/Acuney-Framework/error",
	array(
		"_model"		=> "errorModel",
		"_controller"	=> "errorController"
	)
);

$routegroup->attach(
	$errorroute
);
