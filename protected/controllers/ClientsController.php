<?php

class ClientsController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		$clients = Clients::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'clients' => $clients
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/clients.js');
		$this->render('index', array(
			'clients' => $clients
		));
	}
	
	public function actionGet_Data($id)
	{
		if (null === ($model = Clients::model()->findByPk($id))) {
			return false;
		}
		$this->jsonEcho(array(
			'uid' => $model->uid,
			'socialId' => $model->socialId,
			'name' => $model->name,
			'phone' => $model->phone,
			'email' => $model->email,
			'regDate' => $model->regDate,
			'lastVisit' => $model->lastVisit,
			'login' => $model->login
		));
	}
	
	public function actionEdit() {
		if (!empty($_POST['id']) && null === ($model = Clients::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['id'])) {
			$model = new Clients();
		}
		$model->name = $_POST['name'];
		$model->phone = $_POST['phone'];
		$model->email = $_POST['email'];
		$model->socialId = $_POST['socialId'];
		$model->login = $_POST['login'];
		$model->password = md5($_POST['password']);
		$model->save();
	}
	
	public function actionActivate($id) {
		if (null === ($model = Clients::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->toggleActive();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Clients::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
}

?>
