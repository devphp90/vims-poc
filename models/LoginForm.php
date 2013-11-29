<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $pwd;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that user and pwd are required,
	 * and pwd needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// user and pwd are required
			array('username, pwd', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// pwd needs to be authenticated
			array('pwd', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
			'pwd'=>'Password',
		);
	}

	/**
	 * Authenticates the pwd.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->pwd);
			if(!$this->_identity->authenticate()) {
				if($this->_identity->errorCode == UserIdentity::ERROR_OTHER_LOGIN) {
					$this->addError('pwd', "This account is being logged in");
				} else 
					$this->addError('pwd','Incorrect user or pwd.');
			}
		}
	}

	/**
	 * Logs in the user using the given user and pwd in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->pwd);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
