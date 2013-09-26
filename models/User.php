<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $pwd
 * @property integer $role_id
 * @property string $crtn_date
 * @property string $last_login
 * @property string $user_name
 * @property string $user_email
 */
class User extends CActiveRecord
{
	private $_salt = 'A34fgK2';
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			
			
			//ok
			array('last_login,last_login_ip','unsafe'),
			array('username, password, name', 'length', 'max'=>50),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('email', 'length', 'max'=>100),
			array('email','email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, last_login, user_name, user_email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'username' => 'Username',
			'password' => 'Password',
			'last_login' => 'Last Login',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
			));
	}

	public function validatePassword($pwd) {
		return $this->hashPassword($pwd, $this->_salt) === $this->password;
	}

	public function hashPassword($pwd,$salt) {
		return md5($salt.$pwd.$salt);
	}

	public function beforeSave() {
		$this->password = $this->hashPassword($this->password, $this->_salt);
		return true;
	}
}