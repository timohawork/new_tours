<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property string $uid
 * @property integer $tourId
 * @property integer $clientId
 * @property integer $passCount
 * @property integer $isPaid
 * @property integer $paymentType
 * @property integer $summ
 *
 * The followings are the available model relations:
 * @property Clients $client
 * @property Tours $tour
 */
class Orders extends ApModel
{
	const PAYMENT_CASH = 0;
	const PAYMENT_CASHLESS = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('tourId, clientId, passCount', 'required'),
			array('tourId, clientId, passCount, isPaid, paymentType, summ', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'client' => array(self::BELONGS_TO, 'Clients', 'clientId'),
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
			'uid' => 'Uid',
			'tourId' => 'Tour',
			'clientId' => 'Client',
			'passCount' => 'Pass Count',
			'isPaid' => 'Is Paid',
			'paymentType' => 'Payment Type',
			'summ' => 'Summ',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
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
	
	public function getPaymentType()
	{
		$types = self::paymentTypes();
		return $types[$this->paymentType];
	}
	
	public static function paymentTypes()
	{
		return array(
			self::PAYMENT_CASH => 'Наличные',
			self::PAYMENT_CASHLESS => 'Безнал'
		);
	}
}
