<?php



/**

 * This is the model class for table "{{import_routine4}}".

 *

 * The followings are the available columns in table '{{import_routine4}}':

 * @property integer $id

 * @property integer $sup_id

 * @property integer $import_method

 * @property integer $file_type

 * @property string $file_name

 * @property integer $match_column

 * @property integer $sup_match_column

 * @property integer $price_column

 * @property string $price_field

 * @property string $frequency

 * @property string $status

 * @property string $update_time

 */

class ImportRoutine extends CActiveRecord

{

	public $id2;

	public $delimiter = ',',$enclosure = '"';

	public $match_startby = 1;

	public $match_column = 0;

	public $new_map_by = 0;

	public $method_id = 1;

	public $sup_name;

	public $file;

	public $supplier_name;

	public $frequency_term;



	public $ftp_path;



	/**

	 * Returns the static model of the specified AR class.

	 * @return ImportRoutine the static model class

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

		return '{{import_routine}}';

	}



	public function getImportModel()

	{

		if(!isset($this->import)){

			$this->import = new ImportRoutineImport;

			$this->import->import_id = $this->id;

			$this->import->save();

		}

		

		return $this->import;

		

	}

	

	public function getUpdateModel()

	{

		if(!isset($this->update)){

			$this->update = new ImportRoutineUpdate;

			$this->update->import_id = $this->id;

			$this->update->save();

		}

		

		return $this->update;

		

	}

	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			

			

			array('sup_id, method_id,file_id,server_id, price_type', 'numerical', 'integerOnly'=>true),

			array(' zipped_file_name,file_name, price_field,frequency_option, status,fetch_column,unzip', 'safe'),

			array('frequency','numerical','min'=>1,'max'=>23,'integerOnly'=>true),

			array('data_file_type, ftp_username,ftp_path ,ftp_password,ftp_port, email_sender, email_subject, http_username,http_password,match_startby','safe'),

//			array('http_password','safe'),

			

			//////////////////////////////////////////////////

			array('status','validateStatus'),

			array('supplier_name','required'),
            array('sup_match_column', 'required', 'on' => 'sup1'),
			array('default_price','numerical'),

			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),

			//array('match_startby','in','range'=>array('0'),'allowEmpty'=>false,'not'=>true,'message'=>'What row does data start with? is not allow'),

			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),

			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),

			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),

			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),

			array('data_integrity','unsafe'),

			array('ware_id_1,ware_id_2,ware_id_3,ware_id_4,ware_id_5,ware_id_6,default_qty', 'numerical', 'integerOnly'=>true),//not totaly correct

			array('new_map_by,match_column,qoh_type','in','range'=>array('0','1'),'allowEmpty'=>false),

			array('price,min_adv_price, new_sup_vsku, new_mfg_sku, new_upc, new_mfg_name ','length','max'=>100),

			array('new_mfg_part_name, new_sup_sku, new_sup_sku_name, new_sup_description','length','max'=>100),

			array('delimiter,enclosure','length','max'=>5),

			array('ware_1, ware_2, ware_3, ware_4, ware_5, ware_6','length','max'=>100),
            array('sup_match_column', 'numerical', 'integerOnly' => true, 'min' => 1, 'on' => 'sup1'),

			array(' sup_match_column_1, sup_match_column_2, days_to_disco', 'numerical', 'integerOnly'=>true),



			array('http_url','url','defaultScheme'=>'http','validSchemes'=>array('http')),

			array('ftp_server','url','defaultScheme'=>'ftp','validSchemes'=>array('ftp')),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('id,sup_name, import_method, file_id, file_name, match_column, sup_match_column, price_field, frequency, status', 'safe', 'on'=>'search'),

		);

	}



	public function validateStatus($attribute,$params)

	{

		$active = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->active;

		

		if($this->status == 1 && $active == 0){

			$this->addError($attribute, 'Supplier is Inactive, can not start auto update');

		}

		

	}

	

	

	public function afterFind()

	{

		$this->supplier_name = $this->supplier->name;

/*

		$tabs = Tabs::model()->findByAttributes(array('import_routine_id'=>$this->id));

		if($tabs != null)

			$this->id2 = $tabs->import_routine_id_2;

*/

			

		switch($this->frequency_option){

			case 0:

				$this->frequency_term = 'Hour';

				break;

			case 1:

				$this->frequency_term = 'Day';

				break;

			case 2:

				$this->frequency_term = 'Minute';

				break;

		}

	}

	/**

	 * @return array relational rules.

	 */

	public function relations()

	{

		// NOTE: you may need to adjust the relation name and the related

		// class name for the relations automatically generated below.

		return array(

			'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),

			'supnewitem' => array(self::BELONGS_TO, 'SupNewItem', 'sup_id'),

			'import_method' => array(self::BELONGS_TO, 'ImportMethod', 'method_id'),

			'file_type' => array(self::BELONGS_TO, 'ImportFileType', 'file_id'),

			'import_server' => array(self::BELONGS_TO, 'ImportRoutineServer', 'server_id'),

			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),

			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),

			'log'=>array(self::BELONGS_TO, 'Logs','log_id'),

			'import'=>array(self::HAS_ONE,'ImportRoutineImport','import_id'),

			'update'=>array(self::HAS_ONE,'ImportRoutineUpdate','import_id'),

		);

	}



	public function beforeDelete()

	{

		

		if($this->supnewitem != null)

			$this->supnewitem->deleteAll();

	}

	

	public function beforeSave()

	{

		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;



		return true;

	}

	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'id' => 'ID',

			'sup_id' => 'Supplier',

			'import_method' => 'Retrieval Method',

			'file_id' => 'Sheet Type',

			'file_name' => 'Sheet Name',

			'match_column' => 'Match Column',

			'sup_match_column' => 'Sup Match Column',

			'enclosure'=>'Text Qualifier',

			'frequency' => 'Frequency',

			'status' => 'Auto Import/Update',

			'upc'=>'UPC',

			'price'=>'Supplier Price (UBS Cost)',

			'match_startby'=>'What row does data start with?',

			'new_map_by'=>'Map By',

			'new_sup_vsku'=>'Sup vSKU',

			'new_sup_sku'=>'Sup SKU',

			'new_mfg_sku'=>'MPN',

			'new_upc'=>'UPC',

			'new_mfg_name'=>'Mfg Name',

			'new_mfg_part_name'=>'Mfg Part Name',

			'new_sup_sku_name'=>'Sup SKU Name',

			'new_sup_description'=>'Sup Description',

			'min_adv_price'=>'Min Advertised Price (MAP)',

			'price_type'=>'Supplier Sheets',

			'qoh_type'=>'Supplier gives Qty as:',

			'default_price'=>'Default Price if not provided:',

			'method_id'=>'Retrieval Method',

			'zipped_file_name'=>'Un-Zipped Sheet Name',

			'days_to_disco'=>'Time to DISCO',

			'ftp_path' => 'Path',

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

		$criteria->with = array('supplier','import_method','import_server','import','update');

		$criteria->together=true;

		$criteria->compare('t.id',$this->id);

		$criteria->compare('supplier.name',$this->sup_name,true);

		$criteria->compare('method_id',$this->import_method);

		$criteria->compare('file_name',$this->file_name,true);

		$criteria->compare('frequency',$this->frequency,true);

		$criteria->compare('status',$this->status,true);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

			'sort'=>array(

				'defaultOrder'=>'supplier.name',

			),

		));

	}

}