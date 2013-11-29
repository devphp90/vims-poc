<?php

/**
 * This is the model class for table "ubs_vims_ubs_products".
 *
 * The followings are the available columns in table 'ubs_vims_ubs_products':
 * @property integer $id
 * @property string $ubs_sku
 * @property integer $primary_supplier_ubs_id
 * @property integer $primary_supplier_vims_id
 * @property string $primary_supplier_vsheet_mpn
 * @property string $primary_supplier_vsheet_upc
 * @property string $primary_supplier_vsheet_manufacturer
 * @property string $primary_supplier_vsheet_item_description
 * @property double $primary_supplier_vsheet_price
 * @property double $primary_supplier_vsheet_map_price
 * @property double $primary_supplier_vsheet_our_cost
 * @property integer $primary_supplier_vsheet_qoh
 * @property string $primary_supplier_vsheet_sku
 * @property double $sale_price
 * @property integer $sale_qoh
 * @property string $dtCreated
 */
class UbsVimsUbsProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ubs_vims_ubs_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ubs_sku, primary_supplier_ubs_id, primary_supplier_vims_id, primary_supplier_vsheet_mpn, primary_supplier_vsheet_upc, primary_supplier_vsheet_manufacturer, primary_supplier_vsheet_item_description, primary_supplier_vsheet_price, primary_supplier_vsheet_map_price, primary_supplier_vsheet_our_cost, primary_supplier_vsheet_qoh, primary_supplier_vsheet_sku, sale_price, sale_qoh', 'required'),
			array('primary_supplier_ubs_id, primary_supplier_vims_id, primary_supplier_vsheet_qoh, sale_qoh', 'numerical', 'integerOnly'=>true),
			array('primary_supplier_vsheet_price, primary_supplier_vsheet_map_price, primary_supplier_vsheet_our_cost, sale_price', 'numerical'),
			array('primary_supplier_vsheet_mpn, primary_supplier_vsheet_manufacturer, primary_supplier_vsheet_item_description', 'length', 'max'=>100),
			array('primary_supplier_vsheet_upc', 'length', 'max'=>50),
			array('primary_supplier_vsheet_sku', 'length', 'max'=>250),
			array('dtCreated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ubs_sku, primary_supplier_ubs_id, primary_supplier_vims_id, primary_supplier_vsheet_mpn, primary_supplier_vsheet_upc, primary_supplier_vsheet_manufacturer, primary_supplier_vsheet_item_description, primary_supplier_vsheet_price, primary_supplier_vsheet_map_price, primary_supplier_vsheet_our_cost, primary_supplier_vsheet_qoh, primary_supplier_vsheet_sku, sale_price, sale_qoh, dtCreated', 'safe', 'on'=>'search'),
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
			'ubs_sku' => 'Ubs Sku',
			'primary_supplier_ubs_id' => 'Primary Supplier Ubs',
			'primary_supplier_vims_id' => 'Primary Supplier Vims',
			'primary_supplier_vsheet_mpn' => 'Primary Supplier Vsheet Mpn',
			'primary_supplier_vsheet_upc' => 'Primary Supplier Vsheet Upc',
			'primary_supplier_vsheet_manufacturer' => 'Primary Supplier Vsheet Manufacturer',
			'primary_supplier_vsheet_item_description' => 'Primary Supplier Vsheet Item Description',
			'primary_supplier_vsheet_price' => 'Primary Supplier Vsheet Price',
			'primary_supplier_vsheet_map_price' => 'Primary Supplier Vsheet Map Price',
			'primary_supplier_vsheet_our_cost' => 'Primary Supplier Vsheet Our Cost',
			'primary_supplier_vsheet_qoh' => 'Primary Supplier Vsheet Qoh',
			'primary_supplier_vsheet_sku' => 'Primary Supplier Vsheet Sku',
			'sale_price' => 'Sale Price',
			'sale_qoh' => 'Sale Qoh',
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
		$criteria->compare('ubs_sku',$this->ubs_sku,true);
		$criteria->compare('primary_supplier_ubs_id',$this->primary_supplier_ubs_id);
		$criteria->compare('primary_supplier_vims_id',$this->primary_supplier_vims_id);
		$criteria->compare('primary_supplier_vsheet_mpn',$this->primary_supplier_vsheet_mpn,true);
		$criteria->compare('primary_supplier_vsheet_upc',$this->primary_supplier_vsheet_upc,true);
		$criteria->compare('primary_supplier_vsheet_manufacturer',$this->primary_supplier_vsheet_manufacturer,true);
		$criteria->compare('primary_supplier_vsheet_item_description',$this->primary_supplier_vsheet_item_description,true);
		$criteria->compare('primary_supplier_vsheet_price',$this->primary_supplier_vsheet_price);
		$criteria->compare('primary_supplier_vsheet_map_price',$this->primary_supplier_vsheet_map_price);
		$criteria->compare('primary_supplier_vsheet_our_cost',$this->primary_supplier_vsheet_our_cost);
		$criteria->compare('primary_supplier_vsheet_qoh',$this->primary_supplier_vsheet_qoh);
		$criteria->compare('primary_supplier_vsheet_sku',$this->primary_supplier_vsheet_sku,true);
		$criteria->compare('sale_price',$this->sale_price);
		$criteria->compare('sale_qoh',$this->sale_qoh);
		$criteria->compare('dtCreated',$this->dtCreated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UbsVimsUbsProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
