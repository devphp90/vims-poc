<?php

/**
 * This is the model class for table "{{wizards}}".
 *
 * The followings are the available columns in table '{{wizards}}':
 * @property integer $id
 * @property string $data_md5
 * @property string $data
 * @property string $create_time
 */
class Wizards extends CActiveRecord
{
	public $draft;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wizards the static model class
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
		return '{{wizards}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('data_md5, data', 'required'),
			array('data','safe'),
			array('data_md5', 'length', 'max'=>32),
			array('sup_name', 'length', 'max'=>100),
			array('data_md5','unique'),
			array('sup_id,ware_1,ware_2,ware_3,ware_4,ware_5,ware_6,importroutine_id', 'numerical', 'integerOnly'=>true),
			array('status','in','range'=>array(0,1)),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, data_md5, data, create_time', 'safe', 'on'=>'search'),
		);
	}

	public function afterFind()
	{
		$this->draft = unserialize($this->data);
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
			'data_md5' => 'Data Md5',
			'data' => 'Data',
			'create_time' => 'Create Time',
			'sup_name'=>'Sup Setup Name',
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
		$criteria->compare('data_md5',$this->data_md5,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}