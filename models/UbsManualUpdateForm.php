<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UbsManualUpdateForm extends CFormModel
{
	public $file,$start_at=1;
	public $sku, $sku_name, $sku_description, $mfg_name, $mfg_part_name, $upc, $mfg_title, $price, $vprice;

	/**
	 * Declares the validation rules.
	 * The rules state that user and pwd are required,
	 * and pwd needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('start_at, sku_name, sku_description, mfg_name, mfg_part_name, upc, sku, mfg_title, price, vprice','safe'),
			array('file','file','types'=>'xls,xlsx,txt,csv','allowEmpty'=>false),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'mfg_title'=>'Mfg Name',
			'sku' => 'UBS Sku',
			'sku_name' => 'UBS Sku Name',
			'price' => 'UBS Cost',
			'mfg_name'=>'Manufacturer Part # (MPN)',
			'mfg_part_name'=>'Manufacturer Part # (Plain)',
			'upc'=>'UPC',
			'vprice'=>'UBS Sale Price',
		);
	}


}
