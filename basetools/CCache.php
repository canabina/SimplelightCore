<?php

/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Класс для роботы с кешем
 *
 */

class cache extends Basetools
{

	public function set($id, $data = NULL, $time = 84000){
		return fwrite(fopen($this->request->server('DOCUMENT_ROOT').'/runtime/cache/'.md5($id), 'w'), serialize($data));
	}

	public function get($id){
		return unserialize(file_get_contents($this->request->server('DOCUMENT_ROOT').'/runtime/cache/'.md5($id)));
	}

	public function delete($id){
		return unlink($this->request->server('DOCUMENT_ROOT').'/runtime/cache/'.md5($id));
	}

	public function flush(){
		$dir = scandir($this->request->server('DOCUMENT_ROOT').'/runtime/cache/');
		unset($dir[0], $dir[1]);
		foreach ($dir as $value)
			unlink($this->request->server('DOCUMENT_ROOT').'/runtime/cache/'.$value);
	}
}