<?php

namespace Acuney\Lib;

class HTTP
{
	public static $lastError = '';

	/*
	* @param {string} name 
	*/
	public static function post($name)
	{
		return $_POST[$name];
	}

	/* 
	* @param {string} name
	*/ 
	public static function get($name)
	{
		return $_GET[$name];
	}

	/*
	* @param {string} url
	*/
	public static function validateURL($url)
	{
		if ( !filter_var($url, FILTER_VALIDATE_URL ) )
		{
			return false;
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_NOBODY, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, TRUE);

		$exec = curl_exec($curl);
		curl_close($curl);

		if ( $exec )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	* @param {string} url
	* @param {string} option
	*/
	public static function makeGetRequest($url, $option = 'getonly')
	{
		if ( !self::validateURL($url) )
		{
			self::$lastError = 'URL(' . $url . ') is not valid in function Acuney\Lib\HTTP::makeGetRequest()';
			return false;
		}
			
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		if ( strtolower($option) == 'getonly' )
		{
			if(curl_errno($curl))
			{
				self::$lastError = 'cURL error: ' . curl_error($curl) . ' on URL ' . $url . ' in function Acuney\Lib\HTTP::makeGetRequest()';
				return false;
			}
			else
			{
				$exec = curl_exec($curl);
				curl_close($curl);
				return $exec;
			}
		}
		else
		{
			$exec = curl_exec($curl);
			curl_close($curl);
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
		}
	}

	/*
	* @param {string} url
	* @param {array} postdata
	* @param {string} method
	*/
	public static function makePostRequest($url, $postdata = array(), $method = 'getonly')
	{
		if ( !self::validateURL($url) )
		{
			self::$lastError = 'URL(' . $url . ') is not valid in function Acuney\Lib\HTTP::makeGetRequest()';
			return false;
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		curl_setopt($curl, CURLOPT_POST, count($postdata));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		if ( curl_errno($curl) )
		{
			self::$lastError = 'cURL error: ' . curl_error($curl) . ' on URL ' . $url . ' in function Acuney\Lib\HTTP::makePostRequest()';
			return false;
		}

		$exec = curl_exec($curl);
		curl_close($curl);

		if ( strtolower($method) != 'getonly' )
		{
			return curl_getinfo($curl, CURLOPT_HTTP_CODE);
		}
		else
		{
			return $exec;
		}
	}

	/*
	* @param {string} location
	*/
	public static function redirect($location)
	{
		header('Location: ' . $location);
	}

	/*
	* @param {string} error
	* @param {string} http
	*/
	public static function setError($error, $http = "HTTP/1.0");
	{
		header($error . ' ' . $http);
	}

	public static function currentURI()
	{
		return $_SERVER['REQUEST_URI'];
	}

	/*
	* @param {int} port
	*/
	public static function currentURL($port = 443)
	{
		if ( $_SERVER['SERVER_PORT'] == $port && isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ) 
		{
			return 'https://' . $_SERVER['SERVER_HOST'] . self::currentURI();
		}
		else
		{
			return 'http://' . $_SERVER['SERVER_HOST'] . self::currentURI();
		}
	}

	public static function userAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
}