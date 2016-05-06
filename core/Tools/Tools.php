<?php
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Класс базовых инструментов приложения
 *
 */

class Basetools
{

	protected $classes = [
		'cache' => 'CCache',
		'files' => 'CFiles',
		'request' => 'CRequest',
		'session' => 'CSession',
		'db' => 'CDb',
		'application' => 'CApplication',
		'validator' => 'CValidate',
		'html' => 'CHtml',
	];

	public $tool;

	public function __get($class)
	{
		$f = __DIR__.'/Classes/'.$this->classes[$class].'.php';
		if (!isset($this->tool[$class]) && file_exists($f)){
			require_once __DIR__.'/Classes/'.$this->classes[$class].'.php';
			$this->tool[$class] = new $class;
		}
		return $this->tool[$class];
	}
}
