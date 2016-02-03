<?php 

class Config {
	
	public static function getConfig($key = false)
	{

		$config = require( DOCUMENT_ROOT.'config/config.php' );
		
		return $key ? $config[$key] : $config;

	}

}