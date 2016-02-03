<?php

/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Класс для роботы с сессией
 *
 */


class session extends Basetools
{

	public function removeAllFlash(){
		if (isset($_SESSION['flash']))
			unset($_SESSION['flash']);
	}

	public function setFlash($key, $data = false){
		$_SESSION['flash'][$key] = $data;
	}

	public function set($key, $data = false){
		$_SESSION[$key] = $data;
	}

	public function flush(){
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
	}

	public function delete($key){
		unset($_SESSION[$key]);
	}

	public function get($key = false, $default = false){
		if (!$key)
			return $_SESSION;


		if (isset($_SESSION[$key]) && !empty($_SESSION[$key]))
			return $_SESSION[$key];
		else
			return $default;
	}
}