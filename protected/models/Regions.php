<?php

class Regions extends ApModel
{
	public function tableName() {
		return 'regions';
	}

	public function rules() {
		return array(
			array('title', 'required'),
			array('parentId, startPointId, active', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 128),
			array('description', 'safe')
		);
	}

	public function relations() {
		return array(
			'parent' => array(self::BELONGS_TO, 'Regions', 'parentId'),
			'regions' => array(self::HAS_MANY, 'Regions', 'parentId')
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'parentId' => 'Parent',
			'title' => 'Title',
			'description' => 'Description',
			'startPointId' => 'Start Point',
			'active' => 'Active',
		);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function save($runValidation = true, $attributes = null) {
		if ($this->isNewRecord) {
			$this->uid = md5(date("Y-m-d H:i:s").rand(1000, 10000));
		}
		parent::save($runValidation, $attributes);
	}
}
