<?php 

class SupplierFilterForm extends CFormModel
{

	public $supplier_name;
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name', 'safe'),
		);
	}
}