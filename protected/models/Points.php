<?php

class Points extends ApModel
{
	public $time;
	
	public function tableName() {
		return 'points';
	}

	public function rules() {
		return array(
			array('title, rating, ratingTeh', 'required'),
			array('parentId, rating, ratingTeh, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('title', 'length', 'max' => 128),
			array('shortDesc', 'length', 'max' => 255),
			array('ll', 'length', 'max' => 40),
			array('fullDesc', 'safe')
		);
	}

	public function relations() {
		return array(
            'parent' => array(self::BELONGS_TO, 'Points', 'parentId'),
            'points' => array(self::HAS_MANY, 'Points', 'parentId'),
            'routs' => array(self::MANY_MANY, 'Routs', 'rout_points(pointId, routId)'),
			'images' => array(self::HAS_MANY, 'PointPhotos', 'pointId'),
			'regions' => array(self::MANY_MANY, 'Regions', 'point_regions(pointId, regionId)')
        );
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'parentId' => 'Parent',
			'title' => 'Title',
			'shortDesc' => 'Short Desc',
			'fullDesc' => 'Full Desc',
			'll' => 'Ll',
			'rating' => 'Rating',
			'ratingTeh' => 'Rating Teh',
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
	
	public static function getPoints($params = array())
	{
		if (!empty($params['regionId'])) {
			$pointsIds = PointRegions::model()->findAllByAttributes(array('regionId' => $params['regionId']));
			if (!empty($pointsIds)) {
				return self::model()->findAll("id IN (".(implode(', ', ArrayHelper::columnValues($pointsIds, 'pointId'))).")");
			}
			return array();
		}
		return self::model()->findAll();
	}
}
