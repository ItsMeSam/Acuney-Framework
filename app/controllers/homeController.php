<?php

use Acuney\Router\Router;

class HomeController extends Controller
{
	public function defaultAction()
	{
		return "index";
	}

	public function ignoredActions()
	{
		return array(
			"defaultAction"
		);
	}

	public function index()
	{
		if ( isset ( Router::getParams()[0] ) )
		{
			$this->addVar('param', htmlentities(urldecode(Router::getParams()[0])));
		}
		else
		{
			$this->addVar('param', 'No parameter has been used.');
		}
		$this->parse($this->template);

		ob_start();
		include $this->cachedir . $this->template . ".cache.php";
		return ob_get_clean();
	}
}
