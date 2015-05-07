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
				'actions' => array('index', 'login')
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
	
	public function actionListing()
	{
		if (!empty($_POST['type']) && 'regions' !== $_POST['type'] && empty($_POST['id'])) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		$data = array();
		switch ($_POST['type']) {
			case 'regions':
				foreach (Regions::model()->getList() as $i => $region) {
					$data[$i] = array(
						'header' => array(
							'uid' => $region->uid,
							'parent' => null,
							'title' => $region->title,
						),
						'container' => array(
							'description' => $region->description,
							'active' => $region->active,
							'image' => $region->image,
							'listing' => ArrayHelper::columnValues($region->cities, 'uid')
						)
					);
				}
			break;
		
			case 'cities':
				if (null === ($regionModel = Regions::model()->findByAttributes(array('uid' => $_POST['id'])))) {
					$this->jsonEcho(array(
						'type' => self::TYPE_ERROR,
						'errors' => array('Неверный uid региона.')
					));
				}
				foreach ($regionModel->cities as $i => $city) {
					$data[$i] = array(
						'header' => array(
							'uid' => $city->uid,
							'parent' => $city->region->uid,
							'title' => $city->title,
						),
						'container' => array(
							'description' => $city->description,
							'active' => $city->active,
							'image' => $city->image,
							'listing' => array()
						)
					);
					foreach ($city->groups as $group) {
						$data[$i]['container']['listing'][] = $group->uid;
					}
				}
			break;
		
			case 'groups':
				if (null === ($cityModel = Cities::model()->findByAttributes(array('uid' => $_POST['id'])))) {
					$this->jsonEcho(array(
						'type' => self::TYPE_ERROR,
						'errors' => array('Неверный uid города.')
					));
				}
				foreach ($cityModel->groups as $i => $group) {
					$data[$i] = array(
						'header' => array(
							'uid' => $group->uid,
							'parent' => $cityModel->uid,
							'title' => $group->typeGroup->title,
						),
						'container' => array(
							'typeId' => $group->typeGroup->id,
							'description' => $group->typeGroup->description,
							'active' => $group->active,
							'image' => $group->typeGroup->image,
							'listing' => ArrayHelper::columnValues($group->marks, 'uid')
						)
					);
				}
			break;
		}
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => $data
		));
	}
	
	public function actionTypes_List()
	{
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => Types::getTypes()
		));
	}
	
	public function actionObj_Get()
	{
		if (empty($_POST) || empty($_POST['uid'])) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный uid.')
			));
		}
		
		foreach (array(Marks::model(), CityGroups::model(), Cities::model(), Regions::model()) as $model) {
			if (null !== ($objModel = $model->findByAttributes(array('uid' => $_POST['uid'])))) {
				break;
			}
		}
		
		if (null === $objModel) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный uid.')
			));
		}
		
		$data = array(
			'header' => array(),
			'container' => array()
		);
		
		if ($objModel instanceof Marks) {
			$data['header'] = array(
				'uid' => $objModel->uid,
				'parent' => $objModel->group->uid,
				'type' => 'obj',
				'title' => $objModel->title,
			);
			$data['container'] = array(
				'groupId' => $objModel->groupId,
				'typeId' => $objModel->typeId,
				'description' => $objModel->description,
				'address' => $objModel->address,
				'coord' => $objModel->coord,
				'phone' => $objModel->phone,
				'email' => $objModel->email,
				'skype' => $objModel->skype,
				'viber' => $objModel->viber,
				'site' => $objModel->site,
				'active' => (int)$objModel->active,
				'images' => array(),
				'attr' => array()
			);
			foreach ($objModel->markPhotoses as $image) {
				$data['container']['images'][][] = $image->name;
			}
			foreach ($objModel->attr as $attr) {
				$data['container']['attr'][] = array(
					'title' => $attr->type->title,
					'value' => 'on' === $attr->value ? 1 : $attr->value
				);
			}
		}
		else if ($objModel instanceof Regions) {
			$data['header'] = array(
				'uid' => $objModel->uid,
				'parent' => null,
				'type' => 'dir',
				'title' => $objModel->title,
			);
			$data['container'] = array(
				'description' => $objModel->description,
				'active' => (int)$objModel->active,
				'image' => $objModel->image
			);
		}
		else if ($objModel instanceof Cities) {
			$data['header'] = array(
				'uid' => $objModel->uid,
				'parent' => $objModel->region->uid,
				'type' => 'dir',
				'title' => $objModel->title,
			);
			$data['container'] = array(
				'description' => $objModel->description,
				'active' => (int)$objModel->active,
				'image' => $objModel->image
			);
		}
		else if ($objModel instanceof CityGroups) {
			$data['header'] = array(
				'uid' => $objModel->uid,
				'parent' => $objModel->city->uid,
				'type' => 'dir',
				'title' => $objModel->typeGroup->title,
			);
			$data['container'] = array(
				'description' => $objModel->typeGroup->description,
				'active' => (int)$objModel->active,
				'image' => $objModel->typeGroup->image
			);
		}
		
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => $data
		));
	}
	
	public function actionMark_Edit()
	{
		if (empty($_POST)) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный запрос.')
			));
		}
		if (!empty($_POST['uid']) && null === ($markModel = Marks::model()->findByAttributes(array('uid' => $_POST['uid'])))) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => array('Неверный uid.')
			));
		}
		if (empty($_POST['uid'])) {
			$markModel = new Marks();
		}
		
		$markModel->groupId = (int)ArrayHelper::val($_POST, 'cityId', $markModel->groupId);
		$markModel->typeId = (int)ArrayHelper::val($_POST, 'typeId', $markModel->typeId);
		$markModel->title = ArrayHelper::val($_POST, 'title', $markModel->title);
		$markModel->description = ArrayHelper::val($_POST, 'description', $markModel->description);
		$markModel->address = ArrayHelper::val($_POST, 'address', $markModel->address);
		$markModel->coord = ArrayHelper::val($_POST, 'coord', $markModel->coord);
		$markModel->phone = ArrayHelper::val($_POST, 'phone', $markModel->phone);
		$markModel->email = ArrayHelper::val($_POST, 'email', $markModel->email);
		$markModel->skype = ArrayHelper::val($_POST, 'skype', $markModel->skype);
		$markModel->viber = ArrayHelper::val($_POST, 'viber', $markModel->viber);
		$markModel->site = ArrayHelper::val($_POST, 'site', $markModel->site);
		$markModel->active = '' !== $_POST['active'] ? (int)$_POST['active'] : $markModel->active;
		if (!$markModel->validate()) {
			$this->jsonEcho(array(
				'type' => self::TYPE_ERROR,
				'errors' => $markModel->getErrors()
			));
		}
		$markModel->save();
		$this->jsonEcho(array(
			'type' => self::TYPE_OK,
			'data' => empty($_POST['uid']) ? array('uid' => $markModel->uid) : null
		));
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
}