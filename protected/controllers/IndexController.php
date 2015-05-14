<?php

class IndexController extends ApController
{
	public function filters() {
		return array(
			'accessControl'
		);
	}
	
	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('login'),
				'users' => array('?')
			),
			array(
				'allow',
				'users' => array('@')
			),
			array(
				'deny',
				'users' => array('*')
			)
		);
	}
	
	public function actionIndex() {
		$regions = Regions::model()->findAllByAttributes(array('parentId' => null));
		$date = date("Y-m-d");
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/listing', array(
				'regions' => $regions,
				'date' => ArrayHelper::val($_POST, 'date', $date)
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/index.js');
		$this->render('index', array(
			'regions' => $regions,
			'date' => $date,
			'points' => Points::model()->findAll()
		));
	}
	
	public function actionLogin() {
		if (!Yii::app()->user->isGuest) {
			$this->redirect('/');
		}
		$loginModel = new LoginForm();
		if (Yii::app()->getRequest()->isPostRequest) {
			$loginModel->attributes = $_POST['LoginForm'];
			if ($loginModel->validate() && $loginModel->login()) {
				$this->redirect('/');
			}
		}
		$this->render('login', array('model' => $loginModel));
	}
	
	public function actionLogout() {
		Yii::app()->user->logout(true);
		$this->redirect(Yii::app()->user->loginUrl);
	}
}