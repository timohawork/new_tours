<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ApController extends CController
{
	public function setMessage($key, $message)
	{
		return Yii::app()->user->setFlash($key, $message);
	}

	public function getMessage($key)
	{
		return Yii::app()->user->getFlash($key);
	}

	protected function jsonEcho($var, $isSetHeaders = true)
	{
		if ($isSetHeaders) {
			header('Content-Type: application/json');
		}
		echo CJSON::encode($var);
		Yii::app()->end();
	}

	protected function beforeAction()
	{
		return true;
	}
}