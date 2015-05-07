<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_EMAIL_INVALID = 3;
	
	public $email;
	public $userId;
	public $password;
	
	public function __construct($email, $password)
	{
		$this->email = $email;
		$this->password = $password;
	}
	
	public function getId()
	{
		return $this->userId;
	}
	
	public function authenticate()
	{
		$user = Users::model()->findByAttributes(array('email' => $this->email));
		if (null === $user) {
			$this->errorCode = self::ERROR_EMAIL_INVALID;
		}
		else if (md5($this->password) !== $user->password) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else {
			$this->errorCode = self::ERROR_NONE;
			$this->userId = $user->id;
			$this->username = $user->email;
			$this->email = $user->email;
			$this->password = $user->password;
		}
		return !$this->errorCode;
	}
}