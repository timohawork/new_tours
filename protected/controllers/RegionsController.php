<?php

class RegionsController extends ApController
{
	public function filters() {
		return array(
			'ajaxOnly + get, add, edit, delete, activate',
			'accessControl'
		);
	}
	
	public function actionGet($id) {
		if (null === ($regionModel = Regions::model()->findByPk($id))) {
			Yii::app()->end();
		}
		
		$this->jsonEcho(array('data' => array(
			'id' => $regionModel->id,
			'uid' => $regionModel->uid,
			'title' => $regionModel->title,
			'description' => $regionModel->description,
			'startPointId' => $regionModel->startPointId,
			'startDate' => DateHelper::getDate($regionModel->startDate),
			'endDate' => DateHelper::getDate($regionModel->endDate),
			'image' => $regionModel->image,
			'previewProp' => $regionModel->previewProp
		)));
	}
	
	public function actionAdd() {
		$regionModel = new Regions();
		$regionModel->title = 'Новый';
		if (!empty($_POST['regionId'])) {
			$regionModel->parentId = $_POST['regionId'];
		}
		$regionModel->save();
	}
	
	public function actionEdit() {
		if (empty($_POST) || empty($_POST['id']) || null === ($regionModel = Regions::model()->findByPk($_POST['id']))) {
			Yii::app()->end();
		}
		$regionModel->title = $_POST['name'];
		$regionModel->description = $_POST['description'];
		$regionModel->startPointId = $_POST['startPoint'];
		$regionModel->startDate = $_POST['periodBegin'];
		$regionModel->endDate = $_POST['periodEnd'];
		$regionModel->save();
	}
	
	public function actionDelete($id) {
		if (null === ($regionModel = Regions::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$regionModel->delete();
	}
	
	public function actionActivate($id) {
		if (null === ($regionModel = Regions::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$regionModel->toggleActive();
	}
}