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
	const ROLE_ADMIN = 'admin';
	const ROLE_DISPATCHER = 'dispatcher';
	
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
	
	public static function getRoles()
	{
		return array(
			self::ROLE_ADMIN => 'Администратор',
			self::ROLE_DISPATCHER => 'Диспетчер'
		);
	}
	
	public static function getRoleDesc($role)
	{
		$list = self::getRoles();
		return $list[$role];
	}
	
	public function getRole()
	{
		return Yii::app()->db->createCommand()
			->select('itemname')
			->from('AuthAssignment')
			->where('userId = '.$this->id)
			->queryScalar();
	}
}
