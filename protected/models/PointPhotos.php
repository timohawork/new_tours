<?php

class PointPhotos extends ApModel
{
	const DIR_NAME = "images";
	
	public function tableName() {
		return 'point_photos';
	}

	public function rules()
	{
		return array(
			array('pointId, name', 'required'),
			array('pointId', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 100)
		);
	}

	public function relations()
	{
		return array(
			'point' => array(self::BELONGS_TO, 'Points', 'pointId'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pointId' => 'Point',
			'name' => 'Name',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function delete()
	{
		foreach (array_keys(self::getSizes()) as $size) {
			unlink(dirname(__FILE__).'/../../public/'.self::DIR_NAME.'/'.$this->pointId.'/'.$this->name.'_'.$size.'.jpg');
		}
		parent::delete();
	}
	
	public static function getSizes()
	{
		return array(
			'small' => '150x113',
			'preview' => '600x200',
			'view' => '800x600'
		);
	}
	
	public function getImage($size = 'small')
	{
		return '<img class="img-thumbnail" src="'.self::DIR_NAME.'/'.$this->markId.'/'.$this->name.'_'.$size.'.jpg" alt="">';
	}
}