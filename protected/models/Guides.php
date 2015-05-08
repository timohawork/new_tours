<?php

/**
 * This is the model class for table "guides".
 *
 * The followings are the available columns in table 'guides':
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property integer $spec
 * @property string $regionIds
 * @property string $baseRegion
 * @property string $phone
 * @property integer $rating
 * @property integer $active
 */
class Guides extends ApModel
{
	const HORSE = 0;
	const DIVING = 1;
	const HISTORY = 2;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'guides';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('uid, name, spec', 'required'),
			array('spec, rating, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('name, regionIds', 'length', 'max' => 100),
			array('phone', 'length', 'max' => 30)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			
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
			'name' => 'Name',
			'spec' => 'Spec',
			'regionIds' => 'Region Ids',
			'baseRegion' => 'Base Region',
			'phone' => 'Phone',
			'rating' => 'Rating',
			'active' => 'Active',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Guides the static model class
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
	
	public static function specList()
	{
		return array(
			self::HORSE => 'Конные прогулки',
			self::DIVING => 'Дайвинг',
			self::HISTORY => 'История'
		);
	}
	
	public function getSpec()
	{
		$specs = self::specList();
		return $specs[$this->spec];
	}
}
