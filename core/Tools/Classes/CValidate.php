<?php
/**
 * AltuhovKernel
 *
 * @copyright   2015 Altuhov Konstantin
 * @author      Altuhov Konstantin
 *
 * Валидация данных
 *
 */


class validator extends Basetools
{
	public function validate($data = false, $rules = false){
		if ($data && $rules) {

			foreach ($rules as $key_rule => $value_rule) {
                $value_data = ($data[$key_rule]) ? $data[$key_rule] : false;
				$rule = $value_rule;
				if ($value_data) {
					foreach ($rule as $rkey => $rval) {
						if ($rval === 'string') 
							$param[$key_rule]['isString'] = is_string($value_data);
						if ($rval === 'required') 
							$param[$key_rule]['isRequired'] = !empty($value_data);
						if ($rkey === 'min') 
							(strlen( (is_int($value_data) ? strval($value_data) : $value_data) ) >= $rval) ? $param[$key_rule]['min'] = true : $param[$key_rule]['min'] = false;
						if ($rkey === 'max') 
							(strlen( (is_int($value_data) ? strval($value_data) : $value_data) ) <= $rval) ? $param[$key_rule]['max'] = true : $param[$key_rule]['max'] = false;
						if ($rval === 'email') 
							$param[$key_rule]['email'] = (boolean)filter_var($value_data, FILTER_VALIDATE_EMAIL);
						if ($rval === 'int') 
							$param[$key_rule]['isInteger'] = is_int($value_data);
						if ($rkey === 'uniq') {
							$paramsTable = explode('.', $rval);
							$param[$key_rule]['uniq'] = (boolean)(!Sili::$app->db->get($paramsTable[0], $paramsTable[1], [$paramsTable[1] => $value_data]));
						}
					}
				}else{
					foreach ($rule as $rkey => $rval) {
						if ($rval === 'required')
							$param[$key_rule]['isRequired'] = !empty($value_data);
					}
				}
			}
			$i = 0;
			foreach ($param as $key => $value) 
				foreach ($value as $res) 
					if (!$res) 
						$i++;
			$param['validResult'] = (boolean)(!$i);

			return (object)$param;
		}else
			throw new Exception("Data and Rules is empty");
			
	}
}
