<?php
/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Робота с HTML
 *
 */


class html extends Basetools
{

	//Безопасный вывод HTML на страницу

	public function encode($str = false){
		return $str ? htmlspecialchars($str) : '';
	}

	//Рендер форм
	// EXAMPLE--------------------------------------
	//$arr = [
	// 	'password' => [
	// 		'type' => 'password',
	// 		'placeholder' => 'password',
	// 		'required' => true,
	// 		'value' => 'qwerty',
	// 		'label' => 'Title password'
	// 	],
	// 	'rename_me' => [
	// 		'type' => 'checkbox',
	// 		'label' => 'Rename me',
	// 		'checked' => true,
	// 	],
	// 	'gender' => [
	// 		'type' => 'radio',
	// 		'required' => true,
	// 		'values' => [
	// 			'male' => [
	// 				'label' => 'Male',
	// 				'checked' => true,
	// 			],
	// 			'female' => [
	// 				'label' => 'Female',
	// 			]
	// 		]
	// 	]
	// 'country' => [
	// 	'type' => 'select',
	// 	'required' => true,
	// 	'values' => [
	// 		'USA',
	// 		'Malasia' => true 
	// 	]
	// ]
	// ]
	// EXAMPLE END--------------------------------------

	public function rendreForm($arr){

	}

	public function translit($string) {
	    $converter = array(
	        'а' => 'a',   'б' => 'b',   'в' => 'v',
	        'г' => 'g',   'д' => 'd',   'е' => 'e',
	        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	        'и' => 'i',   'й' => 'y',   'к' => 'k',
	        'л' => 'l',   'м' => 'm',   'н' => 'n',
	        'о' => 'o',   'п' => 'p',   'р' => 'r',
	        'с' => 's',   'т' => 't',   'у' => 'u',
	        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
	        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	        
	        'А' => 'A',   'Б' => 'B',   'В' => 'V',
	        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	        'О' => 'O',   'П' => 'P',   'Р' => 'R',
	        'С' => 'S',   'Т' => 'T',   'У' => 'U',
	        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
	        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	    );
	    return strtr($string, $converter);
	}
	public function stringToUrl($str) {
	    $str = $this->translit($str);
	    $str = strtolower($str);
	    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
	    $str = trim($str, "-");
	    return $str;
	}
}
