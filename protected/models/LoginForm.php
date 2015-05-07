<?php

class LoginForm extends CFormModel
{
	public $email;
	public $password;

	private $_identity;

	public function rules()
	{
		return array(
			array('email', 'required', 'message' => 'Вы должны ввести email.'),
			array('password', 'required', 'message' => 'Вы должны ввести пароль.'),
			array('password', 'authenticate'),
		);
	}

	public function authenticate($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->email, $this->password);
			$this->_identity->authenticate();
			if (UserIdentity::ERROR_NONE !== $this->_identity->errorCode) {
				$this->addError('password', 'Неправильный email или пароль.');
			}
		}
	}

	public function login()
	{
		if (null === $this->_identity) {
			$this->_identity = new UserIdentity($this->email, $this->password);
			$this->_identity->authenticate();
		}
		if (UserIdentity::ERROR_NONE === $this->_identity->errorCode) {
			Yii::app()->user->login($this->_identity, 3600*24*7);
			Yii::app()->user->setState('email', $this->_identity->email);
			return true;
		}
		else {
			return false;
		}
	}
}