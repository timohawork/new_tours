<?php

class Tours extends ApModel
{
	public function tableName() {
		return 'tours';
	}

	public function rules() {
		return array(
			array('uid, routId, type', 'required'),
			array('routId, type, isAction, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('title', 'length', 'max' => 128),
			array('description', 'safe')
		);
	}

	public function relations() {
		return array(
			'rout' => array(self::BELONGS_TO, 'Routs', 'routId'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'title' => 'Title',
			'description' => 'Description',
			'routId' => 'Rout',
			'type' => 'Type',
			'isAction' => 'Is Action',
			'active' => 'Active',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
