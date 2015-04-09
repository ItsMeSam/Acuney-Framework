<?php

namespace Acuney\Router;

class Route
{

	public $uri = '/';
	public $model;
	public $controller;

	public function __construct($uri, $settings)
	{
		$this->uri = $uri;
		$this->model = $settings['_model'];
		$this->controller = $settings['_controller'];
	}
}
