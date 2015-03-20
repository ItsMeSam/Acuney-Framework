<?php

class HomeModel extends Model
{
	public $output;
	public $templatefile;

	public function __construct()
	{
		$this->templatefile = "home.tpl";
	}
}