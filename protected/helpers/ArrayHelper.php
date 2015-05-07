<?php

class ArrayHelper
{
	public static function val($data, $key = '', $defaultValue = '')
	{
		if (is_object($data)) {
			return !empty($data->$key) ? $data->$key : $defaultValue;
		}
		else if (is_array($data)) {
			return !empty($data[$key]) ? $data[$key] : $defaultValue;
		}
		return $defaultValue;
	}

	public static function columnValues($rows, $columnName)
	{
		$res = array();
		foreach ($rows as $r) {
			$res[] = self::val($r, $columnName);
		}
		return $res;
	}
}