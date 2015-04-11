<?php

include "Acuney_lib/Model.class.php";
include "Acuney_lib/Controller.class.php";
include "Acuney_lib/Route.class.php";
include "Acuney_lib/RouteGroup.class.php";
include "Acuney_lib/Router.class.php";
include "Acuney_lib/HTTPLib.class.php";
include "Acuney_lib/DBManager.class.php";
include "Acuney_lib/ConfigHelper.class.php";

/*
* Configuration Handling
*/

//.. App root
define("APP_ROOT", realpath( dirname( dirname( __FILE__ ) ) ));

//.. Core config
use Acuney\Lib\ConfigHelper;
ConfigHelper::setConfig('core');

define("APP_MODELDIR", APP_ROOT .  '/' . ConfigHelper::select('directories@models') . '/');
define("APP_CONTROLLERDIR", APP_ROOT . '/' .  ConfigHelper::select('directories@controllers') . '/');
define("APP_VIEWDIR", APP_ROOT . '/' .  ConfigHelper::select('directories@view') . '/');
define("APP_CACHE", APP_ROOT . '/' . ConfigHelper::select('directories@cache') . '/');

//.. App config
$base = ConfigHelper::select('baseuri', 'app');
$siteurl = str_replace('{base}', $base, ConfigHelper::select('assets', 'app'));
define("SITE_URL", $siteurl);
define("APP_BASE", $base);
