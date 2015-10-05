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
		'db' => 'CDatabase',
		'files' => 'CFiles',
		'request' => 'CRequest',
		'session' => 'CSession',
		'db' => 'CDb',
		'application' => 'CApplication',
		'validator' => 'CValidate'
	];

	public $tool;

	public function __get($class)
	{
		if (!isset($this->tool[$class]) && file_exists(__DIR__.'/../basetools/'.$this->classes[$class].'.php')){
			require_once __DIR__.'/../basetools/'.$this->classes[$class].'.php';
			$this->tool[$class] = new $class;
		}
		return $this->tool[$class];
	}
}
