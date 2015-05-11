<?php

class DateHelper
{
	public static function getDate($date) {
		$date = explode(" ", $date);
		return $date[0] !== '0000-00-00' ? $date[0] : '';
	}
}

?>
