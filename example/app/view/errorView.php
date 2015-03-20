<?php

class errorView extends View
{
	public function output()
	{
		return $this->model->string;
	}
}