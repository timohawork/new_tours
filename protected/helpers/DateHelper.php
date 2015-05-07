<?php

class DateHelper
{
	public static function getDate($date) {
		$date = explode(" ", $date);
		return $date[0];
	}
}

?>
