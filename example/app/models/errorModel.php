<?php

class errorModel extends Model
{
	public $string;

	public function __construct()
	{
		$this->string = " - Oops.. an error occured..";
	}
}