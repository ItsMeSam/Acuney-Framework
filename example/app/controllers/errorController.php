<?php

class errorController extends Controller
{
	private $model;

	public function __construct($model)
	{
		$this->model = $model;
	}

	public function setError($error)
	{
		$this->model->string = $error . $this->model->string;
	}
}