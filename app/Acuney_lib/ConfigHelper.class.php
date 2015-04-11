<?php

namespace Acuney\Lib;

class ConfigHelper
{
  /*
  * @param {string} config
  */
  public static $config;

  /*
  * @param {string} config
  */
  public static function setConfig($config)
  {
    self::$config = self::read($config);
  }

  /*
  * @param {string} config
  */
  protected static function read($configfile)
  {
    if ( !file_exists(APP_ROOT . '/app/config/' . $configfile . ".php") )
    {
      throw new \Exception("Config doesn't exist.");
      return false;
    }

    return require APP_ROOT . '/app/config/' . $configfile . '.php';
  }

  /*
  * @param {string} option
  * @param {string} configfile
  */
  public static function select($option, $configfile = null)
  {
    if ( self::$config == null )
    {
      throw new \Exception("Please use Acuney\Lib\ConfigHelper::setConfig() before using Acuney\Lib\ConfigHelper::select()");
      return false;
    }

    $keys = explode('@', $option);
    $config = (($configfile != null) ? self::read($configfile) : self::$config);

    foreach($keys as $key)
    {
      if ( isset ( $config[$key] ) )
      {
        $config = $config[$key];
      }
      else
      {
        $config = null;
        break;
      }
    }

    return $config;
  }
}
