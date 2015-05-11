<?php

/**
 * This is the model class for table "tours".
 *
 * The followings are the available columns in table 'tours':
 * @property integer $id
 * @property string $uid
 * @property string $title
 * @property string $description
 * @property integer $routId
 * @property integer $type
 * @property integer $totalPass
 * @property integer $childPass
 * @property integer $invalidPass
 * @property string $startDate
 * @property string $finishDate
 * @property integer $carId
 * @property integer $guideId
 * @property string $carCost
 * @property string $guideCost
 * @property string $expenses
 * @property string $margin
 * @property integer $isAction
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Guides $guide
 * @property Cars $car
 * @property Routs $rout
 */
class Tours extends ApModel
{
	const TYPE_INDIVID = 0;
	const TYPE_GROUP = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tours';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('uid, routId, type', 'required'),
			array('routId, type, totalPass, childPass, invalidPass, carId, guideId, isAction, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('title', 'length', 'max' => 128),
			array('carCost, guideCost, expenses, margin', 'length', 'max' => 100),
			array('description', 'safe')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'guide' => array(self::BELONGS_TO, 'Guides', 'guideId'),
			'car' => array(self::BELONGS_TO, 'Cars', 'carId'),
			'rout' => array(self::BELONGS_TO, 'Routs', 'routId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'title' => 'Title',
			'description' => 'Description',
			'routId' => 'Rout',
			'type' => 'Type',
			'totalPass' => 'Total Pass',
			'childPass' => 'Child Pass',
			'invalidPass' => 'Invalid Pass',
			'startDate' => 'Start Date',
			'finishDate' => 'Finish Date',
			'carId' => 'Car',
			'guideId' => 'Guide',
			'carCost' => 'Car Cost',
			'guideCost' => 'Guide Cost',
			'expenses' => 'Expenses',
			'margin' => 'Margin',
			'isAction' => 'Is Action',
			'active' => 'Active',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tours the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function save($runValidation = true, $attributes = null) {
		if ($this->isNewRecord) {
			$this->uid = md5(date("Y-m-d H:i:s").rand(1000, 10000));
		}
		parent::save($runValidation, $attributes);
	}
}
