<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $email
 * @property string $password
 */
class Users extends ApModel
{
	public function tableName()
	{
		return 'users';
	}

	public function rules()
	{
		return array(
			array('email, password', 'required'),
			array('email', 'email'),
			array('email', 'length', 'max' => 60),
			array('password', 'length', 'max' => 32)
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Пароль',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
