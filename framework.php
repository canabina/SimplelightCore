<?php

/**
 * AltuhovKernel
 *
 * @copyright 	2015 Altuhov Konstantin
 * @author 		Altuhov Konstantin
 *
 * Класс ядра
 *
 */

require_once 'core/Core.php';

class Sili extends Core
{

	//Экземпляры классов моделей

	public static $model;

	//Экземпляры базовых классов приложения

	public static $app;
	
	//Класс для роботы с БД (Medoo Documentaion)

	public static $db = false;

	//Инициализируем роботу приложения

	function __construct() {
		$this->run();
	}

}



