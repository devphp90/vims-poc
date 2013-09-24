<?php

/**
 * This is the model class for table "{{tabs_update_log}}".
 *
 * The followings are the available columns in table '{{tabs_update_log}}':
 * @property integer $id
 * @property integer $tabs_id
 * @property integer $data_integrity_status
 * @property string $data_integrity_reason
 * @property integer $qoh_item_percent_change_status
 * @property string $qoh_item_percent_change_reason
 * @property integer $price_item_percent_change_status
 * @property string $price_item_percent_change_reason
 * @property integer $instock_item_status
 * @property string $instock_item_reason
 * @property integer $qoh_percent_change_status
 * @property string $qoh_percent_change_reason
 * @property integer $price_percent_change_status
 * @property string $price_percent_change_reason
 *
 * The followings are the available model relations:
 * @property Tabs $tabs
 */
class TabsUpdateLog extends CActiveRecord
{
	const STATUS_FAIL = 2;
	const STATUS_PASS = 3;

	public $_status = array(
		'',
		'PROCESSING',
		'<font color="red">FAIL</font>',
		'<font color="green">PASS</font>',
		'<font color="orange">WARNING</font>'
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabsUpdateLog the static model class
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
		return '{{tabs_update_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabs_id, data_integrity_status, data_integrity_reason, qoh_item_percent_change_status, qoh_item_percent_change_reason, price_item_percent_change_status, price_item_percent_change_reason, instock_item_status, instock_item_reason, qoh_percent_change_status, qoh_percent_change_reason, price_percent_change_status, price_percent_change_reason,finish_time, note, status,checker_item,already_checker_item, finish_item, vsheet_item, instock_item', 'safe'),
			array('tabs_id, data_integrity_status, qoh_item_percent_change_status, price_item_percent_change_status, instock_item_status, qoh_percent_change_status, price_percent_change_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('id, tabs_id, data_integrity_status, data_integrity_reason, qoh_item_percent_change_status, qoh_item_percent_change_reason, price_item_percent_change_status, price_item_percent_change_reason, instock_item_status, instock_item_reason, qoh_percent_change_status, qoh_percent_change_reason, price_percent_change_status, price_percent_change_reason', 'safe', 'on'=>'search'),
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
			'tab' => array(self::BELONGS_TO, 'Tabs', 'tabs_id'),
			'importlog' => array(self::HAS_ONE, 'TabsImportLog', array('tabs_id'=>'tabs_id'),'order'=>'id desc',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tabs_id' => 'Tabs',
			'data_integrity_status' => 'Data Integrity Status',
			'data_integrity_reason' => 'Data Integrity Reason',
			'qoh_item_percent_change_status' => 'Qoh Item Percent Change Status',
			'qoh_item_percent_change_reason' => 'Qoh Item Percent Change Reason',
			'price_item_percent_change_status' => 'Price Item Percent Change Status',
			'price_item_percent_change_reason' => 'Price Item Percent Change Reason',
			'instock_item_status' => 'Instock Item Status',
			'instock_item_reason' => 'Instock Item Reason',
			'qoh_percent_change_status' => 'Qoh Percent Change Status',
			'qoh_percent_change_reason' => 'Qoh Percent Change Reason',
			'price_percent_change_status' => 'Price Percent Change Status',
			'price_percent_change_reason' => 'Price Percent Change Reason',
			'already_checker_item'=>'Already Imported Checkers',
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
		$criteria->compare('tabs_id',$this->tabs_id);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('qoh_item_percent_change_status',$this->qoh_item_percent_change_status);
		$criteria->compare('qoh_item_percent_change_reason',$this->qoh_item_percent_change_reason,true);
		$criteria->compare('price_item_percent_change_status',$this->price_item_percent_change_status);
		$criteria->compare('price_item_percent_change_reason',$this->price_item_percent_change_reason,true);
		$criteria->compare('instock_item_status',$this->instock_item_status);
		$criteria->compare('instock_item_reason',$this->instock_item_reason,true);
		$criteria->compare('qoh_percent_change_status',$this->qoh_percent_change_status);
		$criteria->compare('qoh_percent_change_reason',$this->qoh_percent_change_reason,true);
		$criteria->compare('price_percent_change_status',$this->price_percent_change_status);
		$criteria->compare('price_percent_change_reason',$this->price_percent_change_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function failsearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = 'data_integrity_status = 2 or instock_item_status =2';
		$criteria->compare('id',$this->id);
		$criteria->compare('tabs_id',$this->tabs_id);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('qoh_item_percent_change_status',$this->qoh_item_percent_change_status);
		$criteria->compare('qoh_item_percent_change_reason',$this->qoh_item_percent_change_reason,true);
		$criteria->compare('price_item_percent_change_status',$this->price_item_percent_change_status);
		$criteria->compare('price_item_percent_change_reason',$this->price_item_percent_change_reason,true);
		$criteria->compare('instock_item_status',$this->instock_item_status);
		$criteria->compare('instock_item_reason',$this->instock_item_reason,true);
		$criteria->compare('qoh_percent_change_status',$this->qoh_percent_change_status);
		$criteria->compare('qoh_percent_change_reason',$this->qoh_percent_change_reason,true);
		$criteria->compare('price_percent_change_status',$this->price_percent_change_status);
		$criteria->compare('price_percent_change_reason',$this->price_percent_change_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function supsearch($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'tabs_id=:tabs_id';
		$criteria->params = array(
			'tabs_id'=>$id,
		);
		$criteria->compare('id',$this->id);
		$criteria->compare('tabs_id',$this->tabs_id);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('qoh_item_percent_change_status',$this->qoh_item_percent_change_status);
		$criteria->compare('qoh_item_percent_change_reason',$this->qoh_item_percent_change_reason,true);
		$criteria->compare('price_item_percent_change_status',$this->price_item_percent_change_status);
		$criteria->compare('price_item_percent_change_reason',$this->price_item_percent_change_reason,true);
		$criteria->compare('instock_item_status',$this->instock_item_status);
		$criteria->compare('instock_item_reason',$this->instock_item_reason,true);
		$criteria->compare('qoh_percent_change_status',$this->qoh_percent_change_status);
		$criteria->compare('qoh_percent_change_reason',$this->qoh_percent_change_reason,true);
		$criteria->compare('price_percent_change_status',$this->price_percent_change_status);
		$criteria->compare('price_percent_change_reason',$this->price_percent_change_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id desc',
			),
		));
	}


}