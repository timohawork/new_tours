<?php

class CarsController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$cars = Cars::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'cars' => $cars
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/cars.js');
		$this->render('index', array(
			'cars' => $cars,
			'regions' => Regions::model()->findAll()
		));
	}
	
	public function actionEdit() {
		if (!empty($_POST['id']) && null === ($model = Cars::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['id'])) {
			$model = new Cars();
		}
		$model->name = $_POST['name'];
		$model->type = $_POST['type'];
		$model->passCount = $_POST['passCount'];
		$model->comfort = $_POST['comfort'];
		$model->phone = $_POST['phone'];
		$model->rating = $_POST['rating'];
		$model->baseRegion = $_POST['baseRegion'];
		$model->regionIds = !empty($_POST['regions']) ? implode(",", array_keys($_POST['regions'])) : null;
		$model->save();
	}
	
	public function actionActivate($id) {
		if (null === ($model = Cars::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Cars::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
}