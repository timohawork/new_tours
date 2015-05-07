<?php

class ErrorController extends ApController
{
	public function actionIndex()
	{
		if (($error = Yii::app()->errorHandler->error)) {
			$this->render('index', $error);
		}
	}
}