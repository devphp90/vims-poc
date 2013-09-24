<?php

class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_name;
	
	public function authenticate() {
		$username = strtolower($this->username);
		$user = User::model()->find('LOWER(username)=?', array($username));
		if($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if(!$user->validatePassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else {
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->_name = $user->name;
			
			$this->errorCode = self::ERROR_NONE;

			User::model()->updateByPk($user->id,array('last_login'=>date("Y-m-d H:i:s"),'last_login_ip'=>Yii::app()->request->userHostAddress));
		}
		return $this->errorCode == self::ERROR_NONE;

	}
		
	public function getId() {
		return $this->_id;
	}
	
	public function getName() {
		return $this->_name;
	}
}