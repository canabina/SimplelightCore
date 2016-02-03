<?php
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Базовый класс для отображения страници, все новые контроллеры
 * должны его наследовать.
 *
 */

class Controller extends Core
{

	public $pageTitle;

	public $layout = 'index';

	public $view = false;

	public $configuration;

	public $assets;

	public $module;

	public $viewsPath;

	public $render;

	public $engine;

	public $layoutVars;

	public $actionId;

	public $controllerId;

	public $config;

	function __construct($module, $controllerId, $actionId) {

		$this->module = $module;

		$this->controllerId = $controllerId;

		$this->actionId = $actionId;

		$this->viewsPath = DOCUMENT_ROOT.'app/modules/'.$this->module.'/views/';

		$this->configuration = Sili::getConfig();

		$engineName = $this->configuration['components']['template_engine']['engine_name'];

		if (isset($engineName) && $engineName) {

			$componentTemplateEngineFolder = DOCUMENT_ROOT.'components/templates-engines/';

			$readyName = ucfirst($engineName).'TemplateEngine';

			$templateEngineFolder = $componentTemplateEngineFolder.'engines/'.$this->configuration['components']['template_engine']['engine_name'];

			$engineFile = $templateEngineFolder.'/'.$readyName.'.php';

			if (file_exists($engineFile)) {

				require_once $componentTemplateEngineFolder.'TemplateEngineInterface.php';

				require_once $engineFile;

				$this->engine = new $readyName;

			}else
				throw new Exception("File TemplateEngine.php is not defined", 1);	
				
		}else
			throw new Exception("Select template-engine name in config file", 1);
	}

	public function addToConfigBeforeRender(){

		$this->config = (object)[

			'viewsPath' => $this->viewsPath,

			'moduleName' => $this->module,

			'pageTitle' => false,

			'renderOptions' => false,

			'route' => [

				'actionId' => $this->actionId,

				'controllerId' => $this->controllerId

			],

			'templateEngineConfig' => (@$this->configuration['components']['template_engine']['template_engine_settings'][$this->configuration['components']['template_engine']['engine_name']] ?: false)

		];

		$this->engine->beforeRender($this->config);
	}

	public function addToConfigAfterRender(){

		$this->config->pageTitle = $this->pageTitle;

		$this->config->renderOptions = (object)[
													'template' => $this->render[0],
													'layout' => isset($this->render[2]) ? $this->render[2] : $this->layout,
													'vars' => $this->render[1],
													'layoutVars' => $this->layoutVars
												];

		$this->engine->render($this->config);
	}

	public function renderPartial($templateName, $vars = false){
		return $this->engine->renderPartial($templateName, $vars);
	}

}
