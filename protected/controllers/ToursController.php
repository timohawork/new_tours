<?php

class ToursController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$tours = Tours::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'tours' => $tours
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/tours.js');
		$this->render('index', array(
			'tours' => $tours
		));
	}
	
	public function actionEdit($id = null) {
		if (null !== $id && null === ($model = Tours::model()->findByPk($id))) {
			throw new CHttpException(404, "Такой экскурсии не существует");
		}
		else if (null === $id) {
			$model = new Tours();
		}
		
		if (Yii::app()->request->isPostRequest) {
			$model->routId = $_POST['routId'];
			$model->title = ArrayHelper::val($_POST, 'title', $model->rout->title);
			$model->description = $_POST['description'];
			$model->type = $_POST['type'];
			$model->totalPass = $_POST['totalPass'];
			$model->childPass = $_POST['childPass'];
			$model->invalidPass = $_POST['invalidPass'];
			$model->startDate = $_POST['startDate'];
			$model->finishDate = $_POST['finishDate'];
			$model->isAction = !empty($_POST['isAction']) ? 1 : 0;
			
			$model->guideId = $_POST['guideId'];
			$model->carId = $_POST['carId'];
			
			$model->guideCost = $_POST['guideCost'];
			$model->carCost = $_POST['carCost'];
			$model->expenses = $_POST['expenses'];
			$model->margin = $_POST['margin'];
			
			$model->save();
			$this->redirect("/tours");
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/tour_edit.js');
		$this->render('edit', array(
			'model' => $model,
			'routs' => Routs::model()->findAll(),
			'cars' => Cars::model()->findAll(),
			'guides' => Guides::model()->findAll()
		));
	}
	
	public function actionActivate($id) {
		if (null === ($model = Tours::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Tours::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
	
	public function actionTime_Diff()
	{
		$this->jsonEcho(array('time' => $_POST['startTime']));
	}
}