<?php

class RoutsController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + add, edit, delete, get_group',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'routs' => Routs::getRouts($_POST)
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/routs.js');
		$this->render('index', array(
			'routs' => Routs::getRouts(),
			'regions' => Regions::model()->findAll('parentId IS NULL')
		));
	}
	
	public function actionEdit($id = null) {
		if (null !== $id && null === ($model = Routs::model()->findByPk($id))) {
			throw new CHttpException(404, "Такого маршрута не существует");
		}
		else if (null === $id) {
			$model = new Routs();
		}
		
		if (Yii::app()->request->isPostRequest) {
			$model->title = $_POST['title'];
			$model->description = $_POST['description'];
			$model->complexity = $_POST['complexity'];
			$model->save();
			
			RoutPoints::model()->deleteAllByAttributes(array('routId' => $model->id));
			$startPoint = new RoutPoints();
			$startPoint->routId = $model->id;
			$startPoint->pointId = $_POST['startPoint'];
			$startPoint->type = RoutPoints::START;

			$endPoint = new RoutPoints();
			$endPoint->routId = $model->id;
			$endPoint->pointId = $_POST['endPoint'];
			$endPoint->type = RoutPoints::FINISH;
			if ($startPoint->validate() && $endPoint->validate()) {
				$hasError = false;
				if (!empty($_POST['required_id'])) {
					foreach ($_POST['required_id'] as $i => $id) {
						$requiredPoint = new RoutPoints();
						$requiredPoint->routId = $model->id;
						$requiredPoint->pointId = $id;
						$requiredPoint->type = RoutPoints::REQUIRED;
						$requiredPoint->time = $_POST['required_time'][$i];
						if (!$requiredPoint->save()) {
							$hasError = true;
							break;
						}
					}
				}
				if (!$hasError && !empty($_POST['additional_id'])) {
					foreach ($_POST['additional_id'] as $i => $id) {
						$additionalPoint = new RoutPoints();
						$additionalPoint->routId = $model->id;
						$additionalPoint->pointId = $id;
						$additionalPoint->type = RoutPoints::ADDITIONAL;
						$additionalPoint->time = $_POST['additional_time'][$i];
						if (!$additionalPoint->save()) {
							$hasError = true;
							break;
						}
					}
				}
				if (!$hasError) {
					$model->save();
					$startPoint->save();
					$endPoint->save();
					RoutRegions::model()->deleteAllByAttributes(array('routId' => $model->id));
					if (!empty($_POST['regions'])) {
						foreach ($_POST['regions'] as $id) {
							$relationModel = new RoutRegions();
							$relationModel->routId = $model->id;
							$relationModel->regionId = $id;
							$relationModel->save();
						}
					}
					$this->redirect('/routs');
				}
				else {
					$model->delete();
				}
			}
		}
		
		$points = array(
			'start' => null,
			'finish' => null,
			'required' => array(),
			'additional' => array()
		);
		foreach ($model->points as $point) {
			switch ($point->type) {
				case RoutPoints::START:
					$points['start'] = $point->point;
				break;
			
				case RoutPoints::FINISH:
					$points['finish'] = $point->point;
				break;
			
				case RoutPoints::REQUIRED:
					$point->point->time = $point->time;
					$points['required'][] = $point->point;
				break;
			
				case RoutPoints::ADDITIONAL:
					$point->point->time = $point->time;
					$points['additional'][] = $point->point;
				break;
			}
		}
		
		if (!$model->isNewRecord) {
			$regionPoints = Points::getPoints(array('regionId' => ArrayHelper::columnValues($model->regions, 'id')));
		}
		else {
			$regionPoints = array();
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/rout_edit.js');
		$this->render('edit', array(
			'model' => $model,
			'points' => $regionPoints,
			'routPoints' => $points,
			'regions' => Regions::model()->findAll('parentId IS NULL')
		));
	}
	
	public function actionActivate($id) {
		if (null === ($model = Routs::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Routs::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
	
	public function actionGet_Group($id)
	{
		if (null === ($groupModel = TypesGroups::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$this->jsonEcho(array('data' => $groupModel->attributes));
	}
}