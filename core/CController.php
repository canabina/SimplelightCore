<?php
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Базовый класс для отображения страници, все новые контроллеры
 * должны его екстендить.
 *
 */

class Controller extends Core
{

	//Заголовок страници

	public $pageTitle;

	//Подключаемый Layout. Внутри шаблона ?.tpl должен быть
	//указан {$content} для отображения содержимого страници
	//подключаемой с view

	public $layout = 'index';

	//Подключаемая View

	public $view = false;

	//Экземпляр класса Smarty

	public $design = false;

	public static $designe = false;

	//Конфиг сайта

	public $configuration;

	//Конструктор настраивает Smarty

	public $module;

	function __construct() {
		$this->design = new Smarty;
		$this->configuration = core::getConfig();
		$this->design->setCompileDir(DOCUMENT_ROOT.$this->configuration['compiledDir']);
		$path = DOCUMENT_ROOT.'/app/modules/'.$this->module.'/views/';
		$this->design->template_dir = $path;
	}

	//Функция отображения страници

	public function render() {
		if ($this->view) {
			$path = DOCUMENT_ROOT.'/app/modules/'.$this->module.'/views/';
			$this->design->assign('content', $this->design->fetch($path.$this->view.'.tpl'));
			$this->design->assign('page_title', $this->pageTitle ? $this->pageTitle : $this->configuration['siteName']);
			$this->design->display($path.'layouts/'.$this->layout.'.tpl');
		}
	}

	//Рендер партия

	public function renderPartial($view_name, $vars = false){
		if ($vars)
			$this->assignVars($vars);
		$this->design->display(DOCUMENT_ROOT.'/app/modules/'.$this->module.'/views/'.$view_name.'.tpl');
		return $this->end();
	}

	//Функция для передачи в шаблон переменных

	public function assignVars($vars){
		foreach ($vars as $key => $value)
			$this->design->assign($key, $value);
	}

}
