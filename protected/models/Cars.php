<?php

/**
 * This is the model class for table "cars".
 *
 * The followings are the available columns in table 'cars':
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property string $type
 * @property integer $passCount
 * @property integer $comfort
 * @property string $regionIds
 * @property string $baseRegion
 * @property string $phone
 * @property integer $rating
 * @property integer $active
 */
class Cars extends ApModel
{
	const TYPE_BUS = 0;
	const TYPE_VAN = 1;
	const TYPE_JEEP = 2;
	const TYPE_HORSE = 3;
	const TYPE_BOAT = 4;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('uid, name, type, passCount, comfort, regionIds, baseRegion', 'required'),
			array('type, passCount, comfort, rating, active', 'numerical', 'integerOnly' => true),
			array('uid', 'length', 'max' => 32),
			array('name, regionIds, baseRegion', 'length', 'max' => 100),
			array('phone', 'length', 'max' => 30)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
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
			'type' => 'Type',
			'passCount' => 'Pass Count',
			'comfort' => 'Comfort',
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
	 * @return Cars the static model class
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
	
	public static function typesList()
	{
		return array(
			self::TYPE_BUS => 'Автобус',
			self::TYPE_VAN => 'Минивен',
			self::TYPE_JEEP => 'Джип',
			self::TYPE_HORSE => 'Лошадь',
			self::TYPE_BOAT => 'Катер'
		);
	}
	
	public function getType()
	{
		$specs = self::typesList();
		return $specs[$this->type];
	}
}
