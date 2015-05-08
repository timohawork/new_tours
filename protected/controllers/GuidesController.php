<?php

class GuidesController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$guides = Guides::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'guides' => $guides
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/guides.js');
		$this->render('index', array(
			'guides' => $guides,
			'regions' => Regions::model()->findAll()
		));
	}
	
	public function actionEdit() {
		if (!empty($_POST['id']) && null === ($model = Guides::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['id'])) {
			$model = new Guides();
		}
		$model->name = $_POST['name'];
		$model->spec = $_POST['spec'];
		$model->baseRegion = $_POST['baseRegion'];
		$model->phone = $_POST['phone'];
		$model->rating = $_POST['rating'];
		$model->regionIds = !empty($_POST['regions']) ? implode(",", array_keys($_POST['regions'])) : null;
		$model->name = $_POST['name'];
		$model->save();
	}
	
	public function actionActivate($id) {
		if (null === ($model = Guides::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Guides::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
}