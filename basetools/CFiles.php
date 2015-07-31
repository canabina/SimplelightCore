<?php

/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Класс для роботы с файлами
 *
 */

class files extends Basetools
{

	//Функция принимает массив $_FILES
	//и записывает файл в хранилище

	public function addFiles($files = false, $type = false){

		if ($files)
			move_uploaded_file($files['tmp_name'], self::getFolder($type).$files['name']);

		return $files['name'];
	}

	//Функция возвращает путь к нужной нам папке

	public function getFolder($type = null){
		switch ($type) {
			case 'images':
				$folder = 'uploads/images/';
				break;
			case 'file':
				$folder = 'uploads/files/';
				break;
			default:
				$folder = 'uploads/trash/';
				break;
		}
		return $folder;
	}

}

?>

