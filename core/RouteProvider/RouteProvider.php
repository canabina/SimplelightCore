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

	function __construct($configuration = false){
		if (!$configuration)
			$this->throwErrorMessage("Pleace, set routes in app/routes.php.", 1);

		$this->beforeApplyCurrentRoute($configuration);
	}

	public function beforeApplyCurrentRoute($configuration = false){

		if ($configuration) {
			
			$redirectUri = Sili::$app->request->server('REDIRECT_URL');

			$redirectUriExplode = false;

			if ($redirectUri) 
				$redirectUriExplode = array_filter(explode('/', $redirectUri));

			if ($redirectUriExplode) 
				$redirectUriExplode = array_values($redirectUriExplode);


			if ($redirectUriExplode) 
				foreach ($configuration['modules'] as $moduleName => $moduleSettings)
					if ($redirectUriExplode[0] == $moduleName){
						if ($redirectUriExplode[0] == explode('/', $moduleSettings['url'])[1])
							unset($redirectUriExplode[0]);
						$redirectUriExplode = array_values($redirectUriExplode);
						return $this->researchParam($moduleSettings, $redirectUriExplode, $moduleName);
					} 

			return $this->researchParam($configuration['modules'][$configuration['defaultModule']], $redirectUriExplode, $configuration['defaultModule']);

				
		}else
			$this->throwErrorMessage("Routes configuration incorrect.", 1);
	}

	public function researchParam($configuration, $uriExplode, $moduleName){
		if (!$uriExplode && isset($configuration['routing']['/'])) 
			return $this->executeRoute($currentRoute, $configuration['routing']['/'], false, $moduleName);
		$routingParseResult = [];
		$lenUri = count($uriExplode);
		$currentRoute = '';
		$setToGet = false;
		foreach ($configuration['routing'] as $routeUrl => $routeConf) {
			$urlConfMask = array_filter(explode('/', $routeUrl));
			if ($urlConfMask) 
				$urlConfMask = array_values($urlConfMask);
			else
				continue;
			$res = true;
			$lenUrlConfMask = count($urlConfMask);
			foreach ($urlConfMask as $confMaskKey => $confMaskValue) {
				if ($uriExplode[$confMaskKey] != $confMaskValue)
					if (strpos($confMaskValue, '@') !== false && $lenUrlConfMask <= $lenUri){
						$setToGet[str_replace('@', '', $confMaskValue)] = $uriExplode[$confMaskKey];
						continue;
					}
					else
						$res = false;
			}
			if ($res)
				$routingParseResult[] = $routeUrl; 
		}
		$currentRoute = false;
		if ($routingParseResult) {
			$arrCount = count($routingParseResult);
			if ($arrCount > 1) {
				$lastBiggest = 0;
				$sufixxCount = 0;
				foreach ($routingParseResult as $urlParseValue) {
					$len = count(array_filter(explode('/' , $urlParseValue)));
					if ($len == 1) 
						$sufixxCount++;	
					if ($lastBiggest < $len) {
						$selectBiggest = $urlParseValue;
						$lastBiggest = $len;
					}
				}
				$currentRoute = $selectBiggest;
				if ($sufixxCount == $arrCount) {
					foreach ($routingParseResult as $route) {
						if (strpos($route, '@') === false) {
							$currentRoute = $route;
							break;
						}
					}
				}	
			}else{
				$currentRoute = $routingParseResult[0];
			}
		}

		$conf = isset($configuration['routing'][$currentRoute]) ? $configuration['routing'][$currentRoute] : false;

		return $this->executeRoute($currentRoute, $conf, $setToGet, $moduleName);
	}

	public function executeRoute($routeString, $routeConf, $setToGet = false, $moduleName = false){

		if (is_array($setToGet)) 
			foreach ($setToGet as $key => $value) 
				if ($routeString && strpos($routeString, '@'.$key) !== false) 
					$_GET[$key] = $value;

		$moduleDir = DOCUMENT_ROOT.'app/modules/'.$moduleName;	
		$controllersDir = $moduleDir.'/controllers/';
		$controllerName = ucfirst($routeConf['controller']).'Controller';
		$controllerFileName = $controllersDir.$controllerName.'.php';
		$indexControllerFileName = $controllersDir.'IndexController.php';
		$isAjax = true;

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
			$isAjax = true;
		
		if (!isset($routeConf['action'])) 
			$action_name = 'index';
		else
			$action_name = $routeConf['action'];
		
		if (file_exists($indexControllerFileName)) {
			require_once $indexControllerFileName;
			if (file_exists($controllerFileName)) {
				require_once $controllerFileName;
				if (class_exists($controllerName)) {
					$controller = new $controllerName($moduleName, $controllerName, $action_name);
					if (method_exists($controller, 'beforeAction'))
						$controller->beforeAction();
					$controller->addToConfigBeforeRender();
					if (method_exists($controller, $action_name)) {
						$controller->$action_name($routeConf['defaultParams'] ? $routeConf['defaultParams'] : false);
						if (method_exists($controller, 'afterAction'))
							$controller->afterAction();
					}elseif(method_exists($controller, 'isError')){
						$controller->isError('404', $isAjax);
					}
					$controller->addToConfigAfterRender();
				}
			}else{
				$indexController = new IndexController($moduleName, $controllerName, $action_name);
				if (method_exists($indexController, 'isError')){
					$indexController->addToConfigBeforeRender();
					$indexController->isError('404', $isAjax);
					$indexController->addToConfigAfterRender();
				}	
			}
		}
	}

	public function throwErrorMessage($message = '', $status = 1){
		throw new Exception($message, 1);
	}

}
