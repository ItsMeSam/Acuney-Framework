<?php

include "Acuney_lib/Acuney.class.php";
include "Acuney_lib/Model.class.php";
include "Acuney_lib/Controller.class.php";
include "Acuney_lib/View.class.php";
include "Acuney_lib/Route.class.php";
include "Acuney_lib/RouteGroup.class.php";
include "Acuney_lib/Router.class.php";
include "Acuney_lib/RegTPL.class.php";

use Acuney\Core\Acuney;

$acuney = new Acuney();
$acuney->set('modeldir', 'app/models/');
$acuney->set('viewdir', 'app/view/');
$acuney->set('controllerdir', 'app/controllers/');
$acuney->set('templatedir', '../public/');

