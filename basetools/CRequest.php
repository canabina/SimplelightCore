<?php

/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Класс для роботы с данными реквеста
 *
 */


class request extends Basetools
{

	//Функция перехватчик $_POST данных

	public function post($key = false, $default = false) {

		if (!$key)
			return $_POST;


		if (isset($_POST[$key]) && !empty($_POST[$key]))
			return $_POST[$key];
		else
			return $default;

	}

	//Текущий УРЛ

	public function currentUrl(){
		return 'http://'.$this->server('SERVER_NAME').$this->server('REQUEST_URI');
	}
	
	
	public function isPost(){
		return !empty($_POST);
	}


	//Функция перехватчик $_POST данных

	public function get($key = false, $default = false) {

		if (!$key)
			return $_GET;


		if (isset($_GET[$key]) && !empty($_GET[$key]))
			return $_GET[$key];
		else
			return $default;

	}

	public function server($key = false){
		if ($key)
			return $_SERVER[$key];
		else
			return $_SERVER;
	}
	
	public function isPost(){
		return !empty($_POST);
	}

	//Функция перехватчик $_FILES данных

	public function files($key = false, $default = false) {

		if (!$key)
			return $_FILES;


		if (isset($_FILES[$key]) && !empty($_FILES[$key]))
			return $_FILES[$key];
		else
			return $default;

	}

}
