<?php

/*
* -------------------------
* | Core configuration    |
* -------------------------
* | This is the config-   |
* | uration file of the   |
* | core, everything is   |
* | setup already, so you |
* | don't have to change  |
* | this file. Acuney     |
* | will not work if you  |
* | make a mistake in this|
* | file, edit this only  |
* | if you know what you  |
* | are doing.            |
* -------------------------
*/


return array(
  /*
  * -------------------------
  * | Directories           |
  * -------------------------
  * | Here, you can this    |
  * | all paths of the      |
  * | directories that      |
  * | Acuney is going to    |
  * | use. Make sure that   |
  * | all folders are not   |
  * | mispelled. Only the   |
  * | cache directory will  |
  * | create itself if it   |
  * | doesn't exist already.|
  * | All directories are   |
  * | called from the app   |
  * | root automatically by |
  * | Acuney.               |
  * -------------------------
  */
  'directories'   => array(
    'cache'           => 'cache',
    'view'            => 'View',
    'controllers'     => 'Controllers',
    'models'          => 'Models'
  ),

  /*
  * -------------------------
  * | Debug mode            |
  * -------------------------
  * | With this enabled, you|
  * | will see all errors,  |
  * | useful when developing|
  * | an application!       |
  * | NOTE: Don't use this  |
  * | in production!        |
  * -------------------------
  */
  'debug' => true
);
