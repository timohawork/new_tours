<?php

class DateHelper
{
	public static function getDate($date) {
		$date = explode(" ", $date);
		return $date[0] !== '0000-00-00' ? $date[0] : '';
	}
	
	public static function getTime($date) {
		$date = explode(" ", $date);
		if (!empty($date[1])) {
			$time = explode(":", $date[1]);
			return $time[0].':'.$time[1];
		}
		return '00:00';
	}
}

?>
