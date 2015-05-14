<?php

/**
 * This is the model class for table "tours_orders".
 *
 * The followings are the available columns in table 'tours_orders':
 * @property integer $id
 * @property integer $tourId
 * @property string $orderIds
 * @property integer $carId
 * @property integer $guideId
 *
 * The followings are the available model relations:
 * @property Cars $car
 * @property Guides $guide
 * @property Tours $tour
 */
class ToursOrders extends CActiveRecord
{
	public $orders = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tours_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('tourId, orderIds', 'required'),
			array('tourId, carId, guideId', 'numerical', 'integerOnly' => true),
			array('orderIds', 'length', 'max' => 20)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'car' => array(self::BELONGS_TO, 'Cars', 'carId'),
			'guide' => array(self::BELONGS_TO, 'Guides', 'guideId'),
			'tour' => array(self::BELONGS_TO, 'Tours', 'tourId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tourId' => 'Tour',
			'orderIds' => 'Order Ids',
			'carId' => 'Car',
			'guideId' => 'Guide',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ToursOrders the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterFind() {
		parent::afterFind();
		foreach (explode(",", $this->orderIds) as $id) {
			$this->orders[] = Orders::model()->findByPk($id);
		}
	}
}
