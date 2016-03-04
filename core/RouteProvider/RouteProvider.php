<?php 
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Application RouteProvider class
 *
 */



require_once __DIR__.'/../Config/Config.php';


class RouteProvider extends Config {

	public $default_controller = 'main';

	public $default_action = 'index';

	public $frontend_module_name;

	public $url_data;

	public $modules_names = [];

	public $current_use_module;

	public $getParams = [];

	public $url_settings;

	public $usingQueryModule;

	public $queryString;
	
	function __construct(){

		$this->frontend_module_name = Sili::getConfig('frontend_module_name');
		$this->queryString = !strrchr($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] : explode('?', $_SERVER['REQUEST_URI'])[0];
		$this->url_data = $this->getQueryStringData();
		$this->modules_names = $this->getModulesNames();
		$this->current_use_module = $this->getCurrentModule();
		$this->url_settings = Sili::getConfig('components')['url_maneger'];
		$this->route();
	}

	public function getQueryStringData($input_uri = false){

		$output = !$input_uri ? explode('/', $this->queryString) : explode('/', $input_uri);

		$data_url = [];

		foreach ($output as $key => $value)
			if($value)
				$data_url[] = $value;
		
	
		return $data_url;

	}

	public function getModulesNames(){

		return array_diff(scandir(DOCUMENT_ROOT.'app/modules'), array('..', '.'));

	} 

	public function route(){


		if ($this->modules_names) {

			if ($this->current_use_module['using_query_module']) {
				unset($this->url_data[0]);
				$this->url_data = array_values($this->url_data);
			}

			if (count($this->url_data) > 2) {
				$this->getParams = array_chunk($this->url_data, 2);
				unset($this->getParams[0]);
				$this->addGetParams();
			}


			if (!$this->url_data) {
				$this->url_data[0] = $this->default_controller;
				$this->url_data[1] = $this->default_action;	
			}


			
			$controller_name = ucfirst($this->url_data[0].'Controller');
			$action_name = isset($this->url_data[1]) ? 'action'.ucfirst($this->url_data[1]) : 'actionIndex' ;
			return $this->perfomRoute($this->current_use_module['module_name'], $controller_name, $action_name);


		}else
			throw new Exception("App modules is not defined", 1);
	
		
	}

	public function getCurrentModule(){

		$current_use_module = ['module_name' => $this->frontend_module_name, 'using_query_module' => FALSE];

		if (in_array($this->url_data[0], $this->modules_names)) 
			$current_use_module = ['module_name' => $this->url_data[0], 'using_query_module' => TRUE];
		
		return $current_use_module;
	}

	public function perfomRoute($module_name, $controller_name, $action_name){		

		$moduleDir = DOCUMENT_ROOT.'app/modules/'.$module_name;
		$controllersDir = $moduleDir.'/controllers/';
		$controllerFileName = $controllersDir.$controller_name.'.php';
		$indexControllerFileName = $controllersDir.'IndexController.php';
		if (file_exists($indexControllerFileName)) {
			require_once $indexControllerFileName;
			if (file_exists($controllerFileName)) {
				require_once $controllerFileName;
				if (class_exists($controller_name)) {
					$controller = new $controller_name($module_name, $controller_name, $action_name);
					$controller->addToConfigBeforeRender();
					$controller->always();
					if (method_exists($controller, $action_name)) {
						$controller->$action_name();
					}else{
						$controller->isError();
					}
					$controller->addToConfigAfterRender();
				}
			}else{
				$indexController = new IndexController($module_name, $controller_name, $action_name);
				$indexController->addToConfigBeforeRender();
				$indexController->isError();
				$indexController->addToConfigAfterRender();
			}
			
		}

	}

	public function addGetParams(){
		if ($this->getParams){
			foreach ($this->getParams as $value){
				if ($value[0]){
					$_GET[$value[0]] = isset($value[1]) ? $value[1] : false;
				}
			}
		}
	}
}
