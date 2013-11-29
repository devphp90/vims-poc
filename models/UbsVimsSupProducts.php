<?php

/**
 * This is the model class for table "ubs_vims_sup_products".
 *
 * The followings are the available columns in table 'ubs_vims_sup_products':
 * @property integer $id
 * @property string $action
 * @property string $ubs_sku
 * @property integer $supplier_ubs_id
 * @property string $supplier_name
 * @property string $mpn
 * @property string $upc
 * @property string $supplier_sku
 * @property string $ubs_manufacturer
 * @property string $item_description
 * @property double $our_cost
 * @property integer $qoh
 * @property string $dtCreated
 */
class UbsVimsSupProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ubs_vims_sup_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action, ubs_sku, supplier_ubs_id, supplier_name, mpn, upc, supplier_sku, ubs_manufacturer, item_description, our_cost, qoh, dtCreated', 'required'),
			array('supplier_ubs_id, qoh', 'numerical', 'integerOnly'=>true),
			array('our_cost', 'numerical'),
			array('action', 'length', 'max'=>1),
			array('ubs_sku, mpn, ubs_manufacturer, item_description', 'length', 'max'=>100),
			array('supplier_name', 'length', 'max'=>200),
			array('upc', 'length', 'max'=>50),
			array('supplier_sku', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, action, ubs_sku, supplier_ubs_id, supplier_name, mpn, upc, supplier_sku, ubs_manufacturer, item_description, our_cost, qoh, dtCreated', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'action' => 'Action',
			'ubs_sku' => 'Ubs Sku',
			'supplier_ubs_id' => 'Supplier Ubs',
			'supplier_name' => 'Supplier Name',
			'mpn' => 'Mpn',
			'upc' => 'Upc',
			'supplier_sku' => 'Supplier Sku',
			'ubs_manufacturer' => 'Ubs Manufacturer',
			'item_description' => 'Item Description',
			'our_cost' => 'Our Cost',
			'qoh' => 'Qoh',
			'dtCreated' => 'Dt Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('ubs_sku',$this->ubs_sku,true);
		$criteria->compare('supplier_ubs_id',$this->supplier_ubs_id);
		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('mpn',$this->mpn,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('supplier_sku',$this->supplier_sku,true);
		$criteria->compare('ubs_manufacturer',$this->ubs_manufacturer,true);
		$criteria->compare('item_description',$this->item_description,true);
		$criteria->compare('our_cost',$this->our_cost);
		$criteria->compare('qoh',$this->qoh);
		$criteria->compare('dtCreated',$this->dtCreated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UbsVimsSupProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
