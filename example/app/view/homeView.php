<?php

use Acuney\View\RegTPL;

class HomeView extends View
{

	public function output()
	{
		$tpl = new RegTPL();
		$tpl->setDirectory('public');
		$tpl->setCacheDirectory('cache');

		$tpl->addVar('name', 'sam');
		$tpl->parse($this->model->templatefile);

		ob_start();
		include $tpl->cachedir . $this->model->templatefile . ".cache.php";
		return ob_get_clean();

	}
}
