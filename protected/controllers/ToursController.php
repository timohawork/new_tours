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
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'tours' => Tours::model()->findAll(!empty($_POST['regionId']) ? 'regionId = '.$_POST['regionId'] : '')
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/tours.js');
		$this->render('index', array(
			'tours' => Tours::model()->findAll(),
			'regions' => Regions::model()->findAll('parentId IS NULL')
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
			$model->regionId = $_POST['regionId'];
			$model->title = ArrayHelper::val($_POST, 'title', $model->rout->title);
			$model->description = $_POST['description'];
			$model->type = $_POST['type'];
			$model->totalPass = $_POST['totalPass'];
			$model->childPass = $_POST['childPass'];
			$model->invalidPass = $_POST['invalidPass'];
			$model->startDate = $_POST['startDate'].' '.$_POST['startTime'].':00';
			$model->finishDate = $model->rout->getFinishDate($model->startDate, true);
			$model->isAction = !empty($_POST['isAction']) ? 1 : 0;
			
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
			'regions' => Regions::model()->findAll('parentId IS NULL')
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
		if (
			empty($_POST['startDate']) || 
			empty($_POST['startTime']) || 
			empty($_POST['id']) || 
			null === ($model = Routs::model()->findByPk($_POST['id']))
		) {
			$this->jsonEcho(array(
				'date' => '',
				'time' => '00:00'
			));
		}
		
		$finish = $model->getFinishDate($_POST['startDate'].' '.$_POST['startTime'].':00');
		
		$this->jsonEcho(array(
			'date' => $finish['date'],
			'time' => $finish['time']
		));
	}
}