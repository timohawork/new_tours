<?php

class CitiesController extends ApController
{
	public function filters()
	{
		return array(
			'ajaxOnly + get, add, edit, delete, activate',
			'accessControl'
		);
	}
	
	public function actionGet($id)
	{
		if (null === ($cityModel = Cities::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$data = $cityModel->attributes;
		$data['groups'] = CityGroups::model()->findAllByAttributes(array('cityId' => $cityModel->id));
		$this->jsonEcho(array('data' => $data));
	}
	
	public function actionAdd()
	{
		if (empty($_POST) || empty($_POST['regionId']) || null === ($regionModel = Regions::model()->findByPk($_POST['regionId']))) {
			Yii::app()->end();
		}
		$cityModel = new Cities();
		$cityModel->regionId = $regionModel->id;
		$cityModel->title = 'Новый';
		$cityModel->save();
	}
	
	public function actionEdit()
	{
		if (empty($_POST) || empty($_POST['id']) || null === ($cityModel = Cities::model()->findByPk($_POST['id']))) {
			Yii::app()->end();
		}
		$cityModel->title = $_POST['name'];
		$cityModel->description = $_POST['description'];
		if (!empty($_POST['groups'])) {
			$cityGroups = array();
			foreach ($cityModel->groups as $group) {
				$cityGroups[] = $group->groupId;
			}
			foreach ($cityGroups as $cityGroup) {
				if (!in_array($cityGroup, $_POST['groups'])) {
					CityGroups::model()->findByAttributes(array('groupId' => $cityGroup, 'cityId' => $cityModel->id))->delete();
				}
			}
			foreach ($_POST['groups'] as $postGroup) {
				if (!in_array($postGroup, $cityGroups)) {
					$cityGroupModel = new CityGroups();
					$cityGroupModel->cityId = $cityModel->id;
					$cityGroupModel->groupId = $postGroup;
					$cityGroupModel->save();
				}
			}
		}
		$cityModel->save();
	}
	
	public function actionDelete($id)
	{
		if (null === ($cityModel = Cities::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$cityModel->delete();
	}
	
	public function actionActivate($id)
	{
		if (null === ($cityModel = Cities::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$cityModel->toggleActive();
	}
}