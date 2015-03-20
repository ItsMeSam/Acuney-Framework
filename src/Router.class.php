<?php

namespace Acuney\Router;

class Router
{
	public $routes;

	public $controller;
	public $view;
	public $model;

	public function __construct(RouteGroup $group)
	{
		$this->routes = $group;
	}

	public function match($uri)
	{
		/*
		* If $uri exists in $this->routes,
		* return true and otherwise return
		* false. After returning true, you
		* might use the draw() method with 
		* the current $uri.
		*/
		if ( $this->routes->exist($uri) )
		{
			return true;
		}
		else
		{
			return false;	
		}		
	}

	public function matchCurrent()
	{
		/*
		* If $_SERVER['REQUEST_URI'] exists 
		* in $this->routes,
		* return true and otherwise return
		* false. After returning true, you
		* might use the draw() method with 
		* $_SERVER['REQUEST_URI'].
		*/
		if ( $this->routes->exist($_SERVER['REQUEST_URI']) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function draw($uri)
	{
		/*
		* For error checking, don't use this
		* for any $_SERVER['REQUEST_URI'],
		* make sure you use match() instead
		* and when it returns true, use this
		* method.
		*/
		if ( !$this->routes->exist($uri) )
		{
			throw new \Exception("Route ({$uri}) doesn't exist");
			return false;
		}

		/*
		* Include all the needed classes and
		* then make an instantiance of them.
		* All instantiances will be saved in
		* an property of this class so you 
		* can use the controller before
		* using the run() method in this class.
		*/
		include \Acuney\Core\Acuney::$modeldir . $this->routes->pluck($uri)->model . ".php";
		include \Acuney\Core\Acuney::$controllerdir . $this->routes->pluck($uri)->controller . ".php";
		include \Acuney\Core\Acuney::$viewdir . $this->routes->pluck($uri)->view . ".php";

		$m = $this->routes->pluck($uri)->model;
		$this->model = new $m;

		$c = $this->routes->pluck($uri)->controller;
		$this->controller = new $c($this->model);

		$v = $this->routes->pluck($uri)->view;
		$this->view = new $v($this->controller, $this->model);
	}

	public function run()
	{
		/*
		* Checks if $this->view, $this->model
		* and $this->controller has a parent
		* class of View, Model or Controller.
		* If it has, return the output() method
		* which can be found in the $this->view
		* property in this class.
		*/
		if ( is_a($this->view, 'View') && is_a($this->model, 'Model') && is_a($this->controller, 'Controller') )
		{
			return $this->view->output();
		}
	}
}