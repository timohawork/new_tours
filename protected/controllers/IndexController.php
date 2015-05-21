<?php

class IndexController extends ApController
{
	public function filters() {
		return array(
			'ajaxOnly + support_message',
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
		$isAdmin = Yii::app()->user->checkAccess(Users::ROLE_ADMIN);
		$points = Points::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array(
				'html' => $this->renderPartial('layouts/listing', array(
					'regions' => $regions,
					'isAdmin' => $isAdmin
				), true),
				'points' => $points
			));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/index.js');
		$this->render('index', array(
			'regions' => $regions,
			'isAdmin' => $isAdmin,
			'points' => $points
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
	
	public function actionSupport_Message()
	{
		if (empty($_POST['message'])) {
			return false;
		}
		$message = new Support();
		$message->userId = Yii::app()->user->id;
		$message->message = $_POST['message'];
		$message->save();
	}
}