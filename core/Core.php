<?php
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Базовый класс роботы приложения
 *
 */

require_once 'RouteProvider/RouteProvider.php';

class Core extends RouteProvider
{

	public static $routes;

	public function run(){

		$this->autoload();

		$this->inititation();
		
		parent::__construct(self::$routes);

	}

	public function autoload(){

		require_once DOCUMENT_ROOT.'/app/routes.php';

		require_once 'Tools/Tools.php';

		require_once 'Model/Model.php';

		require_once 'Controller/Controller.php';
	}

	public function inititation(){

		Sili::$model = new Model;

		Sili::$app = new Basetools();

		if (class_exists('Medoo')) {
			$config_db = self::getConfig('db');
			if (isset($config_db['database_name']) && !empty($config_db['database_name'])) 
				Sili::$db = new Medoo($config_db);
		}
				
	}
	
}



