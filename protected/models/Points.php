<?php

class Points extends ApModel
{
	public $time;
	
	public function tableName() {
		return 'points';
	}

	public function rules() {
		return array(
			array('uid, title, ll, rating, ratingTeh, type', 'required'),
			array('parentId, rating, ratingTeh, type, active', 'numerical', 'integerOnly' => true),
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
			'type' => 'Type',
			'active' => 'Active',
		);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
