<?php

class OrdersController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionIndex($client = null) {
		$orders = Orders::model()->findAll(null !== $client ? 'clientId = '.$client : '');
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array('html' => $this->renderPartial('layouts/list', array(
				'orders' => $orders
			), true)));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/orders.js');
		$this->render('index', array(
			'orders' => $orders,
			'tours' => Tours::model()->findAll()
		));
	}
	
	public function actionGet_Data($id)
	{
		if (null === ($model = Orders::model()->findByPk($id))) {
			return false;
		}
		$this->jsonEcho(array(
			'tourId' => $model->tourId,
			'client' => $model->client->name,
			'passCount' => $model->passCount,
			'isPaid' => $model->isPaid,
			'paymentType' => $model->paymentType,
			'summ' => $model->summ
		));
	}
	
	public function actionEdit() {
		if (!empty($_POST['id']) && null === ($model = Orders::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['id'])) {
			//$model = new Orders();
			return false;
		}
		$model->tourId = $_POST['tourId'];
		$model->passCount = $_POST['passCount'];
		$isPaid = !empty($_POST['isPaid']);
		$model->isPaid = $isPaid ? 1 : 0;
		$model->paymentType = $isPaid ? $_POST['paymentType'] : null;
		$model->summ = $isPaid ? $_POST['summ'] : null;
		$model->save();
	}
	
	public function actionDelete($id) {
		if (null === ($model = Orders::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$model->delete();
	}
}

?>