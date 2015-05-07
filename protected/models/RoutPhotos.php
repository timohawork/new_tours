<?php

/**
 * This is the model class for table "rout_photos".
 *
 * The followings are the available columns in table 'rout_photos':
 * @property integer $id
 * @property integer $routId
 * @property string $name
 * @property string $previewProp
 *
 * The followings are the available model relations:
 * @property Routs $rout
 */
class RoutPhotos extends CActiveRecord
{
	const DIR_NAME = "images";
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rout_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('routId, name', 'required'),
			array('routId', 'numerical', 'integerOnly' => true),
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
			'routId' => 'Rout',
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
		return '/'.self::DIR_NAME.'/routs/'.$this->routId.'/'.$this->name.'_'.$size.'.jpg';
	}
}
