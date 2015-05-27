<?php

class ApiController extends ApController
{
	const TYPE_OK = 'ok';
	const TYPE_ERROR = 'error';
	
	public function filters()
	{
		return array(
			'accessControl'
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'users' => array('?'),
				'actions' => array('index', 'login', 'registration')
			),
			array('deny',
				'users' => array('?'),
				'deniedCallback' => $this->getDeniedCallBack()
			)
		);
	}
	
	protected function getDeniedCallBack()
	{
		return function() {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('У вас нет доступа к API.')
			));
		};
	}
	
	public function actionIndex()
	{
		Yii::app()->getClientScript()
			->registerCssFile('/css/api.css')
			->registerScriptFile('/js/app/api.js');
		$this->render('index', array());
	}
	
	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Вход уже выполнен.')
			));
		}
		if (empty($_POST)) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		$loginModel = new LoginForm();
		$loginModel->isClient = true;
		$loginModel->attributes = $_POST;
		if ($loginModel->validate() && $loginModel->login()) {
			$this->jsonEcho(array(
				'type' => self::TYPE_OK,
				'data' => null
			));
		}
		$this->jsonEcho(array(
			'type' => self::TYPE_ERROR,
			'errors' => $loginModel->getErrors()
		));
	}
	
	public function actionRegistration()
	{
		if (!Yii::app()->user->isGuest) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Учётная запиь уже существует.')
			));
		}
		if (empty($_POST)) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		$client = new Clients();
		$client->login = ArrayHelper::val($_POST, 'login');
		$client->password = ArrayHelper::val($_POST, 'password');
		$client->email = ArrayHelper::val($_POST, 'email');
		$client->name = ArrayHelper::val($_POST, 'name');
		$client->phone = ArrayHelper::val($_POST, 'phone');
		$client->socialId = ArrayHelper::val($_POST, 'socialId');
		$client->active = 1;
		if (!$client->validate()) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => $client->getErrors()
			));
		}
		$loginModel = new LoginForm();
		$loginModel->isClient = true;
		$loginModel->email = $client->email;
		$loginModel->password = $client->password;
		$client->password = md5($client->password);
		$client->save();
		$loginModel->login();
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => array('uid' => $client->uid)
		));
	}
	
	public function actionListing()
	{
		$data = array();
		$regions = Regions::model()->findAllByAttributes(array(
			'parentId' => null,
			'active' => 1
		));
		foreach ($regions as $i => $region) {
			$startPoint = Points::startPoint($region->startPointId);
			$data[$i] = array(
				'header' => array(
					'uid' => $region->uid,
					'parent' => null,
					'title' => $region->title,
				),
				'container' => array(
					'description' => $region->description,
					'beginDate' => DateHelper::getDate($region->startDate),
					'endDate' => DateHelper::getDate($region->endDate),
					'image' => $region->imageUrl(),
					'startPoint' => null !== $startPoint ? array(
						'uid' => $startPoint->uid,
						'title' => $startPoint->title,
						'image' => count($startPoint->images) ? $startPoint->images[0]->getUrl('small') : null,
						'll' => $startPoint->ll
					) : null
				)
			);
			
			foreach ($region->regions as $j => $city) {
				$startPoint = Points::startPoint($city->startPointId);
				$data[$i]['cities'][$j] = array(
					'header' => array(
						'uid' => $city->uid,
						'parent' => $city->parent->uid,
						'title' => $city->title,
					),
					'container' => array(
						'description' => $city->description,
						'beginDate' => DateHelper::getDate($city->startDate),
						'endDate' => DateHelper::getDate($city->endDate),
						'image' => $city->imageUrl(),
						'startPoint' => null !== $startPoint ? array(
							'uid' => $startPoint->uid,
							'title' => $startPoint->title,
							'image' => count($startPoint->images) ? $startPoint->images[0]->getUrl('small') : null,
							'll' => $startPoint->ll
						) : null
					)
				);
				
				foreach ($city->routs as $rout) {
					$images = array();
					foreach ($rout->images as $image) {
						$images[] = $image->getUrl('small');
					}
					$data[$i]['cities'][$j]['routs'][] = array(
						'header' => array(
							'uid' => $rout->uid,
							'title' => $rout->title,
						),
						'container' => array(
							'description' => $rout->description,
							'complexity' => $rout->complexity,
							'images' => $images
						)
					);
				}
			}
		}
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => $data
		));
	}
	
	public function actionOrders()
	{
		$data = array();
		$orders = Orders::model()->findAllByAttributes(array(
			'clientId' => Yii::app()->user->id
		), array('order' => 'isPlaced DESC'));
		foreach ($orders as $order) {
			$data[] = array(
				'uid' => $order->uid,
				'tour' => array(),
				'passCount' => $order->passCount,
				'isPaid' => $order->isPaid,
				'paymentType' => $order->paymentType,
				'summ' => $order->summ,
				'isPlaced' => $order->isPlaced
			);
		}
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => $data
		));
	}
	
	public function actionOrder_Create()
	{
		if (empty($_POST) || empty($_POST['tourUid'])) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		if (null === ($tourModel = Tours::model()->findByAttributes(array('uid' => $_POST['tourUid'])))) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Экскурсии с таким uid не существует.')
			));
		}
		$model = new Orders();
		$model->tourId = $tourModel->id;
		$model->clientId = Yii::app()->user->id;
		$model->isPaid = 0;
		$model->isPlaced = 0;
		$model->passCount = ArrayHelper::val($_POST, 'passCount', 1);
		if (!empty($_POST['summ'])) {
			$model->summ = (int)$_POST['summ'];
			$model->paymentType = isset($_POST['paymentType']) ? (int)$_POST['paymentType'] : Orders::PAYMENT_CASH;
		}
		if (!$model->validate()) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => $model->getErrors()
			));
		}
		$model->save();
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => array('uid' => $model->uid)
		));
	}
	
	public function actionOrder_Edit()
	{
		if (empty($_POST) || empty($_POST['uid'])) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		$model = Orders::model()->findByAttributes(array(
			'uid' => $_POST['uid'],
			'clientId' => Yii::app()->user->id
		));
		if (null === $model) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Заказа с таким uid не существует.')
			));
		}
		if (!empty($_POST['tourUid']) && null === ($tourModel = Tours::model()->findByAttributes(array('uid' => $_POST['tourUid'])))) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Экскурсии с таким uid не существует.')
			));
		}
		else if (!empty($_POST['tourUid'])) {
			$model->tourId = $tourModel->id;
		}
		$model->passCount = (int)ArrayHelper::val($_POST, 'passCount', $model->passCount);
		$model->summ = (int)ArrayHelper::val($_POST, 'summ', $model->summ);
		if (isset($_POST['paymentType']) && $_POST['paymentType'] !== '') {
			$model->paymentType = (int)$_POST['paymentType'];
		}
		if (!$model->validate()) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => $model->getErrors()
			));
		}
		$model->save();
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => null
		));
	}
}