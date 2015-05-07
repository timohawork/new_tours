<?php

Yii::import('ext.image.*');

class PhotosController extends ApController
{
	public function filters()
	{
		return array(
			'postOnly',
			'accessControl'
		);
	}
	
	/*public function accessRules()
	{
		return array(
			array(
				'deny',
				'users' => array('?')
			)
		);
	}*/
	
	public function actionUpload() {
		if (empty($_FILES['photo'])) {
			Yii::app()->end();
		}
		$file = $_FILES['photo'];
		if ('image/jpeg' !== $file['type']) {
			$this->jsonEcho(array('error' => 'Неверный формат изображения.'));
		}
		$dir = RoutPhotos::DIR_NAME.'/';
		if (!empty($_POST['routId'])) {
			$dir .= 'routs/'.$_POST['routId'];
		}
		else if (!empty($_POST['regionId'])) {
			$dir .= 'regions/'.$_POST['regionId'];
		}
		$path = dirname(__FILE__).'/../../public/'.$dir;
		if (!is_dir($path)) {
			mkdir($path) && chmod($path, 0755);
		}
		$name = time();
		$masterImage = $previewImage = $smallImage = $image = new Image($file['tmp_name']);
		$master = $image->width / $image->height > 800 / 600 ? Image::HEIGHT : Image::WIDTH;
		
		$masterImage->save($dir.'/'.$name.'_master.jpg');
		$image->resize(800, 600, $master)->crop(800, 600)
			->save($dir.'/'.$name.'_view.jpg');
		$previewImage->resize(600, 450, $master)->crop(600, 200)
			->save($dir.'/'.$name.'_preview.jpg');
		$smallImage->resize(150, 113, $master)->crop(150, 113)
			->save($dir.'/'.$name.'_small.jpg');
		if (!empty($_POST['routId'])) {
			if (null === Routs::model()->findByPk($_POST['routId'])) {
				Yii::app()->end();
			}
			$photoModel = new RoutPhotos();
			if (!empty($_POST['routPhotoId']) && null === ($photoModel = RoutPhotos::model()->findByPk($_POST['routPhotoId']))) {
				Yii::app()->end();
			}
			$photoModel->routId = $_POST['routId'];
			$photoModel->name = $name;
			$photoModel->save();
			$data = $photoModel->attributes;
			$data['isNew'] = empty($_POST['routPhotoId']);
		}
		else if (!empty($_POST['regionId'])) {
			if (null !== ($regionModel = Regions::model()->findByPk($_POST['regionId']))) {
				if (!empty($regionModel->image)) {
					unlink($dir."/".$regionModel->image."_small.jpg");
					unlink($dir."/".$regionModel->image."_preview.jpg");
					unlink($dir."/".$regionModel->image."_view.jpg");
				}
				$regionModel->image = $name;
				$regionModel->save(array('image'));
			}
			$data = array(
				'name' => $name,
				'regionId' => $regionModel->id
			);
		}
		
		$this->jsonEcho(array(
			'data' => $data
		));
	}
	
	public function actionDelete() {
		if (empty($_POST['type']) || empty($_POST['id'])) {
			Yii::app()->end();
		}
		$model = null;
		switch ($_POST['type']) {
			case 'routs':
				$model = RoutPhotos::model()->findByPk($_POST['id']);
			break;
		
			case 'regions':
				$model = Regions::model()->findByPk($_POST['id']);
			break;
		}
		
		if (null === $model) {
			Yii::app()->end();
		}
		if ($model instanceof RoutPhotos) {
			$model->delete();
		}
		else {
			$model->image = null;
			$model->previewProp = null;
			$model->save();
		}
	}
	
	public function actionFrame_Edit() {
		if (empty($_POST)) {
			Yii::app()->end();
		}
		if ('regions' === $_POST['type']) {
			$model = Regions::model();
		}
		else if ('routs' === $_POST['type']) {
			$model = RoutPhotos::model();
		}
		if (null === ($model = $model->findByPk($_POST['id']))) {
			Yii::app()->end();
		}
		$name = dirname(__FILE__).'/../../public/'.RoutPhotos::DIR_NAME.'/'.$_POST['type'].'/';
		if ('regions' === $_POST['type']) {
			$name .= $model->id.'/'.$model->image;
		}
		else if ('routs' === $_POST['type']) {
			$name .= $model->routId.'/'.$model->name;
		}
		$image = new Image($name.'_view.jpg');
		$image->crop($_POST['width'], $_POST['height'], $_POST['top'], $_POST['left'])
			->resize(600, 200)
			->save($name.'_preview.jpg');
		$model->previewProp = $_POST['width'].'x'.$_POST['height'].'x'.$_POST['top'].'x'.$_POST['left'];
		$model->save(array('previewProp'));
		$this->jsonEcho(array());
	}
}