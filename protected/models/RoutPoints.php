<?php

class RoutPoints extends CActiveRecord
{
	const START = 0;
	const FINISH = 1;
	const REQUIRED = 2;
	const ADDITIONAL = 3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'rout_points';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('routId, pointId, type', 'required'),
			array('routId, pointId, type', 'numerical', 'integerOnly' => true)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
            'point' => array(self::BELONGS_TO, 'Points', 'pointId'),
            'rout' => array(self::BELONGS_TO, 'Routs', 'routId'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'routId' => 'Rout',
			'pointId' => 'Point',
			'type' => 'Type',
			'time' => 'Time',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
