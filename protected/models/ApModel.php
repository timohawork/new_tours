<?php

class ApModel extends CActiveRecord
{
	public function toggleActive()
	{
		if (isset($this->active)) {
			$this->active = !$this->active ? 1 : 0;
			$this->save(array('active'));
			return true;
		}
		return false;
	}
}