<?php
/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Класс моделей приложения
 *
 */

class Model
{

	public $model;

	public function __get($class)
	{

		if (!isset($this->model[$class]) && file_exists($_SERVER['DOCUMENT_ROOT'].'/app/models/'.$class.'.php')){
			require_once $_SERVER['DOCUMENT_ROOT'].'/app/models/'.$class.'.php';
			$this->model[$class] = new $class;
		}
		return $this->model[$class];
	}
}