<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ManualUpdateForm extends CFormModel
{
	public $file;

	/**
	 * Declares the validation rules.
	 * The rules state that user and pwd are required,
	 * and pwd needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('file','file','types'=>'xls,xlsx,txt,csv','allowEmpty'=>false),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
//			'file'=>'Remember me next time',
		);
	}


}
