<?php

/**
 * This is the model class for table "point_regions".
 *
 * The followings are the available columns in table 'point_regions':
 * @property integer $pointId
 * @property integer $regionId
 */
class PointRegions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'point_regions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('pointId, regionId', 'required'),
			array('pointId, regionId', 'numerical', 'integerOnly' => true)
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
			'pointId' => 'Point',
			'regionId' => 'Region',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PointRegions the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
