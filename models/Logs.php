<?php

/**
 * This is the model class for table "{{logs}}".
 *
 * The followings are the available columns in table '{{logs}}':
 * @property integer $id
 * @property integer $import_id
 * @property string $import_status
 * @property integer $file_size
 * @property integer $item_number
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property ImportRoutine $import
 * @property LogsDetail[] $logsDetails
 */
class Logs extends CActiveRecord
{
	public $_status = array('<font color="red">FAIL</font>','<font color="green">PASS</font>','<font color="orange">WARNING</font>','PROCESSING');

	public $sup_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Logs the static model class
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
		return '{{logs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('import_id, file_size, item_number, import_status', 'numerical', 'integerOnly'=>true),
			
			////////////////////////
			array('status','in','range'=>array('0','1')),
			array('prepare_reason, data_integrity_reason, overall_item_reason, instock_item_reason, qoh_reason, price_reason','unsafe'),
			array('prepare_status, data_integrity_status,overall_item_status, instock_item_status, qoh_status, price_status','in','range'=>array('0','1','2','3')),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
				array('id, import_id, sup_name,import_status, file_size, item_number, create_time, update_time, status', 'safe', 'on'=>'search'),
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
			'supplier'=> array(self::HAS_ONE,'Supplier',array('sup_id'=>'id'),'through'=>'routine'),
			'routine' => array(self::BELONGS_TO, 'ImportRoutine', 'import_id'),
			'logsDetails' => array(self::HAS_MANY, 'LogsDetail', 'log_id'),
			'update'=>array(self::HAS_ONE,'ImportRoutineUpdate',array('import_id'=>'import_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'import_id' => 'Import Id',
			'import_status' => 'Download Status',
			'prepare_status'=>'Import vSheet Status',
			'import_reason' => 'Reason',
			'file_size' => 'File Size (Bytes)',
			'item_number' => 'Item Count',
			'create_time' => 'Import Start Time',
			'update_time' => 'Update End Time',
			'overall_item_status'=>'Row Count Test',
			'instock_item_status'=>'Instock Item Test',
			'status' => 'Status',
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
		$criteria->with = 'supplier';
		$sort = new CSort();
		$sort->attributes = array(
			'id',
			'import_id',
			'sup_name'=>array(

				'asc'=>'supplier.id',
			  	'desc'=>'supplier.id desc',
			),
			'create_time',
			't.update_time',
		);
		$sort->defaultOrder = 't.update_time DESC';
		$criteria->compare('id',$this->id);
		$criteria->compare('import_id',$this->import_id);
		$criteria->compare('supplier.name',$this->sup_name,true);
		$criteria->compare('import_status',$this->import_status,true);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('item_number',$this->item_number);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchSupplier($import_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = 'supplier';
		$sort = new CSort();
		$criteria->condition = 'import_id=:import_id';
		$criteria->params = array(':import_id'=>$import_id);
		$sort->attributes = array(
			'id',
			'import_id',
			'sup_name'=>array(

				'asc'=>'supplier.id',
			  	'desc'=>'supplier.id desc',
			),
			'create_time',
			't.update_time',
		);
		$sort->defaultOrder = 't.update_time DESC';
		$criteria->compare('id',$this->id);
		$criteria->compare('import_id',$this->import_id);
		$criteria->compare('supplier.name',$this->sup_name,true);
		$criteria->compare('import_status',$this->import_status,true);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('item_number',$this->item_number);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}