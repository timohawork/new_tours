<?php

class OrdersController extends ApController
{
	public function filters()
	{
		return array(
			'ajaxOnly + create, edit, get_data, get_calendar',
			'accessControl'
		);
	}
	
	public function actionIndex() {
		Yii::app()->getClientScript()
			->registerCssFile('/css/calendar.css')
			->registerScriptFile('/js/app/orders.js');
		$this->render('index');
	}
	
	public function actionDay($date)
	{
		$tours = Tours::model()->findAll('startDate >= :start AND startDate <= :end AND active = 1', array(
			':start' => $date.' 00:00:00',
			':end' => $date.' 23:59:59'
		));
		
		$indicators = array(
			'placed' => 0,
			'notPlaced' => 0
		);
		foreach ($tours as $tour) {
			$indicators['notPlaced'] += Orders::passSummCount($tour->orders);
			foreach ($tour->toursOrders as $order) {
				$indicators['placed'] += Orders::passSummCount($order->orders);
			}
		}
		
		if (Yii::app()->request->isAjaxRequest) {
			$this->jsonEcho(array(
				'html' => $this->renderPartial('layouts/list', array('tours' => $tours), true),
				'indicators' => $indicators
			));
		}
		
		Yii::app()->getClientScript()
			->registerScriptFile('/js/app/order_day.js');
		$this->render('day', array(
			'date' => $date,
			'tours' => $tours,
			'indicators' => $indicators,
			'guides' => Guides::model()->findAll(),
			'cars' => Cars::model()->findAll()
		));
	}
	
	public function actionGet_Data($id)
	{
		if (null === ($model = ToursOrders::model()->findByPk($id))) {
			return false;
		}
		$orders = array();
		foreach ($model->orders as $order) {
			$orders[] = array(
				'id' => $order->id,
				'client' => $order->client->name.' ('.$order->client->phone.')',
				'passCount' => $order->passCount,
				'summ' => $order->isPaid ? $order->summ : 0,
				'paymentType' => $order->isPaid ? $order->getPaymentType() : null
			);
		}
		$notPlacedOrders = array();
		foreach ($model->tour->orders as $notPlaced) {
			$notPlacedOrders[] = array(
				'id' => $notPlaced->id,
				'client' => $notPlaced->client->name.' ('.$notPlaced->client->phone.')',
				'passCount' => $notPlaced->passCount,
				'summ' => $notPlaced->isPaid ? $notPlaced->summ : 0,
				'paymentType' => $notPlaced->isPaid ? $notPlaced->getPaymentType() : null
			);
		}
		$this->jsonEcho(array(
			'orders' => $orders,
			'carId' => $model->carId,
			'guideId' => $model->guideId,
			'notPlaced' => $notPlacedOrders,
			'tourId' => $model->tourId
		));
	}
	
	public function actionEdit()
	{
		if (!empty($_POST['id']) && null === ($model = ToursOrders::model()->findByPk($_POST['id']))) {
			return false;
		}
		if (empty($_POST['orders'])) {
			foreach ($model->orders as $order) {
				$order->isPlaced = 0;
				$order->save();
			}
			$model->delete();
			$this->jsonEcho(array('error' => false));
		}
		
		$model->guideId = $_POST['guideId'];
		$model->carId = $_POST['carId'];
		
		if (!empty($_POST['orders'])) {
			$totalPass = 0;
			foreach ($_POST['orders'] as $id) {
				$totalPass += Orders::model()->findByPk($id)->passCount;
			}
			if ($totalPass > $model->car->passCount) {
				$this->jsonEcho(array('error' => true));
			}
		}
		
		$model->orderIds = implode(",", $_POST['orders']);
		foreach ($model->orders as $order) {
			$order->isPlaced = 0;
			$order->save();
		}
		foreach ($_POST['orders'] as $id) {
			$orderModel = Orders::model()->findByPk($id);
			$orderModel->isPlaced = 1;
			$orderModel->save();
		}
		$model->save();
		
		$this->jsonEcho(array('error' => false));
	}
	
	public function actionCreate()
	{
		if (empty($_POST['orders']) || (!empty($_POST['tourId']) && null === ($tourModel = Tours::model()->findByPk($_POST['tourId'])))) {
			return false;
		}
		
		$model = new ToursOrders();
		$model->tourId = $tourModel->id;
		$model->guideId = $_POST['guideId'];
		$model->carId = $_POST['carId'];
		
		if (!empty($_POST['orders'])) {
			$totalPass = 0;
			foreach ($_POST['orders'] as $id) {
				$totalPass += Orders::model()->findByPk($id)->passCount;
			}
			if ($totalPass > $model->car->passCount) {
				$this->jsonEcho(array('error' => true));
			}
		}
		
		$model->orderIds = implode(",", $_POST['orders']);
		foreach ($model->orders as $order) {
			$order->isPlaced = 0;
			$order->save();
		}
		foreach ($_POST['orders'] as $id) {
			$orderModel = Orders::model()->findByPk($id);
			$orderModel->isPlaced = 1;
			$orderModel->save();
		}
		$model->save();
		
		$this->jsonEcho(array('error' => false));
	}
	
	public function actionGet_Calendar()
	{
		$monthDiff = Yii::app()->request->getPost('monthDiff');
		$month = date('m') + $monthDiff;
		$year = date('Y');
		if (1 > $month) {
			$month = 12 - abs($month);
			$year--;
		}
		else if (12 < $month) {
			$month = $month - 12;
			$year++;
		}
		$daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
		$dayCount = 1;
		$num = 0;
		$days = array();
		for ($i = 0; $i < 7; $i++) {
			$dayOfWeek = date('w', mktime(0, 0, 0, $month, $dayCount, $year)) - 1;
			if (-1 == $dayOfWeek) {
				$dayOfWeek = 6;
			}
			if ($i == $dayOfWeek) {
				$days[$num][$i] = array(
					'num' => $dayCount,
					'counters' => Tours::getDayCounters($year."-".$month."-".$dayCount)
				);
				$dayCount++;
			}
			else {
				$days[$num][$i] = "";
			}
		}

		while (true) {
			$num++;
			for ($i = 0; $i < 7; $i++) {
				$days[$num][$i] = array(
					'num' => $dayCount,
					'counters' => Tours::getDayCounters($year."-".$month."-".$dayCount)
				);
				$dayCount++;
				if ($dayCount > $daysInMonth) {
					break;
				}
			}
			if ($dayCount > $daysInMonth) {
				break;
			}
		}
		
		$this->jsonEcho(array('html' => $this->renderPartial('layouts/calendar', array(
			'year' => $year,
			'month' => 10 > $month ? '0'.$month : $month,
			'monthDiff' => $monthDiff,
			'days' => $days,
			'today' => date("Y-m-d")
		), true)));
	}
}

?>