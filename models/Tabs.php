<?php

/**
 * This is the model class for table "{{tabs}}".
 *
 * The followings are the available columns in table '{{tabs}}':
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $import_routine_id
 * @property integer $create_by
 * @property integer $update_by
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TabsWarehouse[] $tabsWarehouses
 */
class Tabs extends CActiveRecord
{
	public $supplier_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tabs the static model class
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
		return '{{tabs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name', 'required'),
			array('supplier_id, import_routine_id, filetime', 'numerical', 'integerOnly'=>true),
			array('price_override_percent_change, qty_override_percent_change','numerical','min'=>0,'max'=>100),
			array('supplier_name','unique','className'=>'Supplier','attributeName'=>'name'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instock_item,column_number','numerical'),
			array('status, price_override_status, qty_override_status','in','range'=>array(0,1)),
			array('price_override_start, price_override_end, qty_override_start, price_override_end', 'date', 'format'=>'yyyy-M-d'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),

			array('id, supplier_id, import_routine_id, create_by, update_by, create_time, update_time, status, supplier_name', 'safe', 'on'=>'search'),
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
			'tabsWarehouses' => array(self::HAS_MANY, 'TabsWarehouse', 'tabs_id'),
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),

			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
			'importRoutine' => array(self::BELONGS_TO, 'ImportRoutine', 'import_routine_id'),
			'importRoutine2' => array(self::BELONGS_TO, 'ImportRoutine', 'import_routine_id_2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_id' => 'Supplier',
			'import_routine_id' => 'Import Routine',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'status' => 'Status',
		);
	}

	public function beforeDelete()
	{
		if($this->importRoutine != null)
			$this->importRoutine->delete();
		if($this->importRoutine2 != null)
			$this->importRoutine2->delete();
		if($this->supplier != null)
			$this->supplier->delete();
		return true;
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

		$criteria->with = 'supplier';
		$criteria->compare('id',$this->id);
		if (strpos($this->supplier_name, '*') !== false) {
			$supplierName = str_replace('*', '%', $this->supplier_name);
			$criteria->addCondition("supplier.name LIKE '{$supplierName}'");
		} else {
			$criteria->compare('supplier.name',$this->supplier_name,true);
		}
		$criteria->compare('import_routine_id',$this->import_routine_id);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		// $criteria->compare('status',$this->status);
		$criteria->compare('supplier.active', $this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
			'sort'=>array(
				'defaultOrder'=>'supplier.name',
			),
		));
	}

    protected function beforeSave()
    {
        $this->update_time = date('Y-m-d H:i:s');
        $this->update_by = Yii::app()->user->id;
        return parent::beforeSave();
    }
}