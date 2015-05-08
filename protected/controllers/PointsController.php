<?php

class PointsController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$points = Points::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'points' => $points
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/points.js');
		$this->render('index', array(
			'points' => $points
		));
	}
	
	public function actionEdit($id = null) {
		if (null !== $id && null === ($model = Points::model()->findByPk($id))) {
			throw new CHttpException(404, "Такого объекта не существует");
		}
		else if (null === $id) {
			$model = new Points();
		}
		if (Yii::app()->request->isPostRequest) {
			$model->title = $_POST['title'];
			$model->shortDesc = $_POST['shortDesc'];
			$model->fullDesc = $_POST['fullDesc'];
			$model->ll = $_POST['ll'];
			$model->rating = $_POST['rating'];
			$model->ratingTeh = $_POST['ratingTeh'];
			$model->ratingInside = $_POST['ratingInside'];
			$model->phone = $_POST['phone'];
			$model->address = $_POST['address'];
			$model->email = $_POST['email'];
			$model->workTime = $_POST['workTime'];
			$model->comment = $_POST['comment'];
			$model->maxCount = $_POST['maxCount'];
			
			$model->save();
			$this->redirect('/points');
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/point_edit.js');
		$this->render('edit', array(
			'model' => $model
		));
	}
	
	public function actionActivate($id) {
		if (null === ($model = Points::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Points::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
}