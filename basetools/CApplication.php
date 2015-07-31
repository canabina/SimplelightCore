<?php

/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Класс для роботы с приложением
 *
 */


class application extends Basetools
{

	//Функция редиректа. $url - страница

	public function redirect($url, $end = false, $message = '') {
		header("location: $url");
		if ($end)
			$this->end($message);
	}

	//Завершает роботу приложения

	public function end($message = false){
		exit($message);
	}
}