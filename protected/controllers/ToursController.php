<?php

class ToursController extends ApController
{
	public function filters()
	{
		return array(
			//'ajaxOnly + edit, get_type, activate',
			'accessControl'
		);
	}
	
	public function actionEdit($id = null) {
		/*if (empty($_POST)) {
			Yii::app()->end();
		}
		$typeModel = new Types();
		$typeModel->attributes = $_POST;
		$typeModel->save();
		
		TypesAttr::model()->deleteAllByAttributes(array('typeId' => $typeModel->id));
		foreach ($_POST['attr']['name'] as $i => $name) {
			$attrModel = new TypesAttr();
			$attrModel->typeId = $typeModel->id;
			$attrModel->title = $name;
			$attrModel->type = $_POST['attr']['value'][$i];
			$attrModel->save();
		}
		$this->jsonEcho(array('types' => Types::getTypes()));*/
		$this->render('edit', array(
			
		));
	}
	
	public function actionGet_Type($id) {
		if (null === ($typeModel = Types::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$data = $typeModel->attributes;
		$data['attr'] = $typeModel->attr;
		$this->jsonEcho(array('data' => $data));
	}
	
	public function actionActivate($id) {
		if (null === ($groupModel = CityGroups::model()->findByPk($id))) {
			Yii::app()->end();
		}
		$groupModel->toggleActive();
	}
}