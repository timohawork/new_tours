<?php

/**
 * This is the model class for table "clients".
 *
 * The followings are the available columns in table 'clients':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $regDate
 * @property string $uid
 * @property string $socialId
 * @property string $lastVisit
 * @property string $login
 * @property string $password
 * @property integer $active
 */
class Clients extends ApModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, login, password', 'required'),
			array('active', 'numerical', 'integerOnly' => true),
			array('name, phone, email, socialId, login', 'length', 'max' => 100),
			array('email', 'email'),
			array('password', 'length', 'min' => 6, 'max' => 32),
			array('login, email', 'unique'),
			array('lastVisit', 'safe')
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
			'name' => 'Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'regDate' => 'Reg Date',
			'uid' => 'Uid',
			'socialId' => 'Social',
			'lastVisit' => 'Last Visit',
			'login' => 'Login',
			'password' => 'Password',
			'active' => 'Active',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clients the static model class
	 */
	public static function model($className=__CLASS__)
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
