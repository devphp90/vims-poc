<?php

/**
 * This is the model class for table "{{import_routine_update}}".
 *
 * The followings are the available columns in table '{{import_routine_update}}':
 * @property integer $id
 * @property integer $import_id
 * @property string $data_integrity
 * @property string $last_update_list
 * @property integer $overall_item
 * @property integer $instock_item
 * @property integer $last_update_time
 */
class ImportRoutineUpdate extends CActiveRecord
{
	public $updateGlobal;
	public $supplierGlobal;
	public $supplierGlobalNotFound;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportRoutineUpdate the static model class
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
		return '{{import_routine_update}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('last_update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('import_id, overall_item, instock_item', 'numerical', 'integerOnly'=>true),
			array('data_integrity,last_update_list','unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, import_id, data_integrity, last_update_list, overall_item, instock_item, last_update_time', 'safe', 'on'=>'search'),
		);
	}

	public function getGlobalQaModel()
	{
		if(!isset($this->updateGlobal))
			$this->updateGlobal = UpdateQaGlobal::model()->find();
		
		return $this->updateGlobal;	
	}
	
	public function getSupplierQaModel($sup_id)
	{
		if(!isset($this->supplierGlobal) && !isset($this->supplierGlobalNotFound )){
			$this->supplierGlobal = UpdateQaSupplier::model()->find('sup_id=?',array($sup_id));
			$this->supplierGlobalNotFound = 1;
		}
			
			
		return $this->supplierGlobal;
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
			'routine' => array(self::BELONGS_TO, 'ImportRoutine', array('id'=>'import_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'import_id' => 'Import',
			'data_integrity' => 'Data Integrity',
			'last_update_list' => 'Last Update List',
			'overall_item' => 'Overall Item',
			'instock_item' => 'Instock Item',
			'last_update_time' => 'Last Update Time',
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
		$criteria->compare('import_id',$this->import_id);
		$criteria->compare('data_integrity',$this->data_integrity,true);
		$criteria->compare('last_update_list',$this->last_update_list,true);
		$criteria->compare('overall_item',$this->overall_item);
		$criteria->compare('instock_item',$this->instock_item);
		$criteria->compare('last_update_time',$this->last_update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}