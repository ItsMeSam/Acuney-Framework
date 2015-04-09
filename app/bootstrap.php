<?php

include "Acuney_lib/Acuney.class.php";
include "Acuney_lib/Model.class.php";
include "Acuney_lib/Controller.class.php";
include "Acuney_lib/View.class.php";
include "Acuney_lib/Route.class.php";
include "Acuney_lib/RouteGroup.class.php";
include "Acuney_lib/Router.class.php";
include "Acuney_lib/HTTPLib.class.php";
include "Acuney_lib/DBManager.class.php";

use Acuney\Core\Acuney;

$acuney = new Acuney();
$acuney->set('modeldir', 'app/models/');
$acuney->set('viewdir', 'View/');
$acuney->set('controllerdir', 'app/controllers/');
$acuney->set('templatedir', '../public/');
$acuney->set('basepath', '/Acuney-Framework'); //.. This is for MVC routing
$acuney->set('cachedir','../../cache/');

//.. Site configuration
define("SITE_URL", "http://127.0.0.1/Acuney-Framework/View/Home/"); //.. This is for the assets, by this option, you can make the question: Where are my assets stored?
