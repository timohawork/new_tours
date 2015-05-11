<?php

class Routs extends ApModel
{
	public function tableName() {
		return 'routs';
	}

	public function rules() {
		return array(
			array('complexity, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('title', 'length', 'max' => 128),
			array('description', 'safe')
		);
	}

	public function relations() {
		return array(
            'points' => array(self::HAS_MANY, 'RoutPoints', 'routId'),
            'tours' => array(self::HAS_MANY, 'Tours', 'routId'),
			'images' => array(self::HAS_MANY, 'RoutPhotos', 'routId')
        );
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'title' => 'Title',
			'description' => 'Description',
			'complexity' => 'Complexity',
			'active' => 'Active',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function save($runValidation = true, $attributes = null) {
		if ($this->isNewRecord) {
			$this->uid = md5(date("Y-m-d H:i:s").rand(1000, 10000));
		}
		parent::save($runValidation, $attributes);
	}
	
	public function getStartPoint()
	{
		foreach ($this->points as $point) {
			if ($point->type == RoutPoints::START) {
				return $point->point;
			}
		}
	}
}
