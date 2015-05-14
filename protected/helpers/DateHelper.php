<?php

class DateHelper
{
	public static function monthName($month)
	{
		switch ($month) {
			case 1:
				return 'Январь';
			break;
		
			case 2:
				return 'Февраль';
			break;
		
			case 3:
				return 'Март';
			break;
		
			case 4:
				return 'Апрель';
			break;
		
			case 5:
				return 'Май';
			break;
		
			case 6:
				return 'Июнь';
			break;
		
			case 7:
				return 'Июль';
			break;
		
			case 8:
				return 'Август';
			break;
		
			case 9:
				return 'Сентябрь';
			break;
		
			case 10:
				return 'Октябрь';
			break;
		
			case 11:
				return 'Ноябрь';
			break;
		
			case 12:
				return 'Декабрь';
			break;
		}
	}
	
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
