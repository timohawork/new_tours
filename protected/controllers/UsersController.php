<?php

class UsersController extends ApController
{
	public function filters()
	{
		return array(
			'ajaxOnly + edit, delete',
			'accessControl'
		);
	}
	
	public function accessRules() {
		return array(
			array(
				'allow',
				'roles' => array(Users::ROLE_ADMIN)
			),
			array(
				'deny',
				'users' => array('*')
			)
		);
	}
	
	public function actionIndex() {
		$users = Users::model()->findAll();
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'users' => $users
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/users.js');
		$this->render('index', array(
			'users' => $users
		));
	}
	
	public function actionEdit() {
		if (!empty($_POST['id']) && null === ($model = Users::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['id'])) {
			$model = new Users();
		}
		
		$model->email = $_POST['email'];
		if (empty($_POST['id']) || !empty($_POST['password'])) {
			$model->password = md5($_POST['password']);
		}
		$model->save();
		$role = $model->getRole();
		$auth = Yii::app()->authManager;
		if ($model->isNewRecord) {
			$auth->assign($_POST['role'], $model->id);
		}
		else if ($role !== $_POST['role']) {
			$auth->revoke($role, $model->id);
			$auth->assign($_POST['role'], $model->id);
		}
	}
	
	public function actionDelete($id) {
		if (null === ($model = Users::model()->findByPk($id))) {
			Yii::app()->end();
		}
		Yii::app()->authManager->revoke($model->getRole(), $model->id);
		$model->delete();
	}
}

?>