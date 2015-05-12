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
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'points' => Points::getPoints($_POST)
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/points.js');
		$this->render('index', array(
			'points' => Points::getPoints(),
			'regions' => Regions::model()->findAll('parentId IS NULL')
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
			
			PointRegions::model()->deleteAllByAttributes(array('pointId' => $model->id));
			if (!empty($_POST['regions'])) {
				foreach ($_POST['regions'] as $id) {
					$relationModel = new PointRegions();
					$relationModel->pointId = $model->id;
					$relationModel->regionId = $id;
					$relationModel->save();
				}
			}
			
			$this->redirect('/points');
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/point_edit.js');
		$this->render('edit', array(
			'model' => $model,
			'regions' => Regions::model()->findAll('parentId IS NULL')
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
	
	public function actionGet_Points()
	{
		if (empty($_POST['regions'])) {
			$this->jsonEcho(array('points' => array()));
		}
		$response = array();
		foreach (Points::getPoints(array('regionId' => $_POST['regions'])) as $point) {
			$response[] = array(
				'id' => $point->id,
				'title' => $point->title
			);
		}
		$this->jsonEcho(array('points' => $response));
	}
}