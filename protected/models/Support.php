<?php

/**
 * This is the model class for table "support".
 *
 * The followings are the available columns in table 'support':
 * @property integer $id
 * @property integer $userId
 * @property string $message
 * @property string $created
 * @property integer $isSeen
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Support extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'support';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('userId, message', 'required'),
			array('userId, isSeen', 'numerical', 'integerOnly' => true)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'message' => 'Message',
			'created' => 'Created',
			'isSeen' => 'Is Seen',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Support the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
