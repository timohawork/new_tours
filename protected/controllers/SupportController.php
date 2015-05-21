<?php

class SupportController extends ApController
{
	public function filters()
	{
		return array(
			'ajaxOnly + delete',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$messages = Support::model()->findAll(array("order" => "isSeen ASC, created DESC"));
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'messages' => $messages
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/messages.js');
		$this->render('index', array(
			'messages' => $messages
		));
	}
	
	public function actionDelete($id)
	{
		if (null === ($model = Support::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
	
	public function actionSeen($id)
	{
		if (null === ($model = Support::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->isSeen = 1;
		$model->save();
	}
}