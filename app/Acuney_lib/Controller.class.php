<?php

require_once "RegTPL.class.php";

abstract class Controller extends Acuney\View\RegTPL
{
  public $template;

  /*
  * @param {string} template
  */
  public function setTemplate($template)
  {
    $this->template = $template;
  }
}
