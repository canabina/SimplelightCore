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

require_once 'CBase.php';

class Core extends Base
{

	//Экземпляры классов моделей

	public static $model;

	//Экземпляры базовых классов приложения

	public static $app;
	
	//Класс для роботы с БД (Medoo Documentaion)

	public static $db;

	//Инициализируем роботу приложения

	function __construct() {
		$this->run();
	}

	//Выполнения необходимых действий
	//при завершении роботы скрипта

	function __destruct() {
		self::$app->session->removeAllFlash();
	}

}


