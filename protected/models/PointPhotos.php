<?php

/**
 * This is the model class for table "point_photos".
 *
 * The followings are the available columns in table 'rout_photos':
 * @property integer $id
 * @property integer $pointId
 * @property string $name
 * @property string $previewProp
 *
 * The followings are the available model relations:
 * @property Points $point
 */
class PointPhotos extends CActiveRecord
{
	const DIR_NAME = "images";
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'point_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('pointId, name', 'required'),
			array('pointId', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 100),
			array('previewProp', 'length', 'max' => 20)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'point' => array(self::BELONGS_TO, 'Points', 'pointId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pointId' => 'Point',
			'name' => 'Name',
			'previewProp' => 'Preview Prop',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoutPhotos the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function delete()
	{
		foreach (array_keys(self::getSizes()) as $size) {
			unlink(dirname(__FILE__).'/../../public/'.$this->getUrl($size));
		}
		unlink(dirname(__FILE__).'/../../public/'.$this->getUrl('master'));
		parent::delete();
	}
	
	public static function getSizes()
	{
		return array(
			'small' => '150x113',
			'preview' => '600x200',
			'view' => '800x600'
		);
	}
	
	public function getUrl($size = 'small')
	{
		return '/'.self::DIR_NAME.'/points/'.$this->pointId.'/'.$this->name.'_'.$size.'.jpg';
	}
}