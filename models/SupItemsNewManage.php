<?php

/**
 * This is the model class for table "{{sup_new_item4}}".
 *
 * The followings are the available columns in table '{{sup_new_item4}}':
 * @property integer $id
 * @property integer $import_id
 * @property string $data
 */
class SupItemsNewManage extends CActiveRecord
{
    public $testvalue = 0, $testvalue1 = 0, $testvalue2 = 0;
    public $match_by_status = array(
        self::MATCH_VSKU => 'vSKU',
        self::MATCH_MPN_UPC_NAME => 'MPN+UPC+Nam',
        self::MATCH_MPN_UPC => 'MPN+UPC',
        self::MATCH_MPN_NAME => 'MPN+Nam',
        self::MATCH_UPC => 'UPC',
        self::MATCH_MPN => 'MPN'
    );
    public $showData = array();
    public $showColumn = array();
    public $sup_id;
    public $statusList = array('Undecide', 'Imported', 'No Import');
    public $price_diff;
    public $match = 2;
    public $percent_diff;
    public $match_by;
    public $importStatus = 'Will Import';
    public $isCalculated = 0;
    public $ubs_sku;

    const MATCH_VSKU = 1;
    const MATCH_MPN_UPC_NAME = 6;
    const MATCH_MPN_UPC = 2;
    const MATCH_MPN_NAME = 3;
    const MATCH_UPC = 5;
    const MATCH_MPN = 4;
    const MATCH_STATUS_YES = 1;
    const MATCH_STATUS_NO = 0;
    const MATCH_STATUS_MISMATCH = 3;
    const MATCH_STATUS_UNDECIDED = 2;

	
	public function getItemQty()
	{
		
	}
	
    /**
     * Returns the static model of the specified AR class.
     * @return SupNewItem4 the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{sup_items_new_manage}}';
    }

    public function unserializeData()
    {

        $this->showData = unserialize(base64_decode($this->data));
        $this->showColumn = unserialize($this->column);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('import_id,item_status, match_by,match_ubs_id', 'numerical', 'integerOnly' => true),
            array('sup_price', 'numerical'),
            array('mfg_sku,sup_vsku,upc,mfg_name,mfg_part_name,sup_sku,sup_sku_name,sup_description, qty_total', 'safe'),
            array('create_time', 'default', 'setOnEmpty' => false, 'value' => date("Y-m-d H:i:s"), 'on' => 'insert'),
            array('create_by', 'default', 'setOnEmpty' => false, 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('update_by', 'default', 'setOnEmpty' => false, 'value' => Yii::app()->user->id, 'on' => 'update'),
            array('update_time', 'default', 'setOnEmpty' => false, 'value' => date("Y-m-d H:i:s"), 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,match_by, qty_total, sup_id,sup_vsku, import_id,match_by, data,mfg_sku,upc,mfg_name,mfg_part_name,sup_sku,sup_sku_name,sup_description,match, sup_price, ubs_sku,price_diff, percent_diff', 'safe', 'on' => 'search'),
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
            'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
            /*
              'ubsinventory' => array(self::BELONGS_TO, 'UbsInventory', array('mfg_sku'=>'mfg_name','upc'=>'upc'),
              'on'=>'ubsinventory.mfg_name!=\'\'',
              ),
             */
            'ubsinventory' => array(self::BELONGS_TO, 'UbsInventory', 'match_ubs_id'),
            'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
            'supplier' => array(self::HAS_ONE, 'Supplier', array('sup_id' => 'id'), 'through' => 'import_routine'),
            'import_routine' => array(self::BELONGS_TO, 'ImportRoutine', 'import_id', 'together' => true),
            'checker_count' => array(self::STAT, 'SupItemsNewManage', 'id'),
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
            'data' => 'Data',
            'mfg_sku' => 'MPN',
            'upc' => 'UPC',
            'sup_sku' => 'Sup SKU',
            'sup_vsku' => 'Sup vSKU',
            'sup_sku_name' => 'Sup Item Name',
        );
    }

    public function afterSave()
    {
        if (!$this->isCalculated) {
            $this->isNewRecord = false;
            $this->calculate();
            $this->isCalculated = 1;
            $this->save();
        }
    }

    public function calculate()
    {
        // Moved to Update script since we need to insert new item per "match"
        /**
          $this->match_by = 0;
          $vsku = SupInventory::model()->find('lower(sup_vsku)=?',array(strtolower(trim($this->sup_vsku))));
          if($vsku != null && !empty($vsku->sup_vsku) && isset($vsku->ubs_inventory->id)){
          $this->match_by = self::MATCH_VSKU;
          $this->match_ubs_id = $vsku->ubs_inventory->id;
          }


          if(!$this->match_by){
          $mpnupc = UbsInventory::model()->find(array(
          'condition'=>'upc=:upc and mfg_name=:mfg_sku',
          'params'=>array(
          ':upc'=>$this->upc,
          ':mfg_sku'=>$this->mfg_sku,
          ),
          ));
          if($mpnupc != null){
          $this->match_by = self::MATCH_MPN_UPC;
          $this->match_ubs_id = $mpnupc->id;
          }
          }

          if(!$this->match_by){
          //			$mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku,'mfg_title'=>$this->mfg_name));
          //			if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name) && !empty($mpnmfgtitle->mfg_title))){
          if ($model = UbsInventory::model()->find(array(
          'condition' => 'mfg_name=:name AND mfg_title=:title',
          'params'    => array(':name' => $this->mfg_sku, ':title' => $this->mfg_name)
          ))) {
          if (!empty($model->mfg_name) && !empty($model->mfg_title)) {
          $this->match_by = self::MATCH_MPN_NAME;
          $this->match_ubs_id = $model->id;
          }
          }
          }

          if(!$this->match_by){
          $mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku));
          if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name))){
          $this->match_by = self::MATCH_MPN;
          $this->match_ubs_id = $mpnmfgtitle->id;
          }
          }

          if(!$this->match_by){
          $mpnupc = UbsInventory::model()->find(array(
          'condition'=>'upc=:upc',
          'params'=>array(
          ':upc'=>$this->upc
          ),
          ));
          if($mpnupc != null && !empty($mpnupc->upc)){
          $this->match_by = self::MATCH_UPC;
          $this->match_ubs_id = $mpnupc->id;
          }
          }

          //		if($this->match_by == ''){
          //			$mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku));
          //			if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name))){
          //				$this->match_by = 4;
          //				$this->match_ubs_id = $mpnmfgtitle->id;
          //			}
          //		}
         * */
    }

    public function afterFind()
    {

        switch ($this->match_by) {
            case 0:
                break;
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            default:
        }
        if (Yii::app()->controller->action->id == 'newItemLink') {
            if ($this->match_by != '') {
                $model = new SupInventory;
                $model->sup_vsku = $this->sup_vsku;
                $model->mfg_sku = $this->mfg_sku;
                $model->mfg_upc = $this->upc;
                $model->mfg_name = $this->mfg_name;
                $model->mfg_sku_name = $this->mfg_part_name;
                $model->sup_sku = $this->sup_sku;
                $model->sup_sku_name = $this->sup_sku_name;
                $model->sup_description = $this->sup_description;
                $model->sup_id = $this->import_routine->sup_id;
                $model->ubs_id = $this->ubsinventory->id;
                $model->sup_status = 1;
                $model->supplier_name = $this->import_routine->supplier->name;
                if (!$model->validate()) {
                    $this->importStatus = '';
                    $i = 1;
                    foreach ($model->getErrors() as $attribute => $reason)
                        $this->importStatus .= $i++ . '. ' . $attribute . '=>' . implode(',', $reason) . '     ';
                }
            }else
                $this->importStatus = 'No Match will not import!';
        }
    }

    public function showData()
    {
        $this->unserializeData();
        foreach ($this->showData as $id => $value) {
            if ($id > 2) {
                echo '...';
                break;
            }

            echo $this->showColumn[$id], ': ';
            echo $value;
            echo '<br/>';
        }
    }

    public function showAll()
    {
        
    }

    public function searchChecker()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        //$vsku = SupInventory::model()->find('lower(sup_vsku)=?',array(strtolower(trim($this->sup_vsku))));
        //$mpnupc = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku,'upc'=>$this->upc));
        //$mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku,'mfg_title'=>$this->mfg_name));
        //$criteria->select = array('*,,,;
//		$criteria->select = array(
//			'*',
//			'(select 10 from vims_sup_inventory where lower(sup_vsku)=t.sup_vsku limit 1) as testvalue',
//			'(select 3 from vims_ubs_inventory as gg where gg.mfg_name=t.mfg_sku and gg.upc=t.upc limit 1) as testvalue1',
//			'(select 1 from vims_ubs_inventory as yy where yy.mfg_name=t.mfg_sku and yy.mfg_title=t.mfg_name limit 1) as testvalue2',
//		);
        $criteria->with = array('supplier', 'ubsinventory');
        $criteria->together = true;
        $criteria->condition = 'item_status=0';
        //$criteria->join = 'left join ';
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->compare('supplier.name', $this->sup_id, true);
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);
        $criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $criteria->compare('t.upc', $this->upc, true);
        $criteria->compare('t.mfg_name', $this->mfg_name, true);
        $criteria->compare('t.mfg_part_name', $this->mfg_part_name, true);


        $criteria->compare('`match`', $this->match);
//		$row = Yii::app()->db->createCommand(array(
//
//			    'select' => array('count(id) as itemnumber'),
//			    'from' => "vims_sup_newitem",
//			))->queryRow();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 100,
                    ),
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.price-t.sup_price)',
                                'desc' => '(ubsinventory.price-t.sup_price) desc',
                            ),
                            'percent_diff' => array(
                                'asc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price',
                                'desc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price desc',
                            ),
                        ),
//				'defaultOrder'=>'testvalue desc,testvalue1 desc, testvalue2 desc',
                    ),
//			'totalItemCount'=>$row['itemnumber'],
                ));
    }

    public function searchGroupSupchecker($supid)
    {

        $criteria = new CDbCriteria;
        $criteria->select = array(
            '*',
            '(select 10 from vims_sup_inventory where lower(sup_vsku)=t.sup_vsku limit 1) as testvalue',
            '(select 3 from vims_ubs_inventory as gg where gg.mfg_name=t.mfg_sku and gg.upc=t.upc limit 1) as testvalue1',
            '(select 1 from vims_ubs_inventory as yy where yy.mfg_name=t.mfg_sku and yy.mfg_title=t.mfg_name limit 1) as testvalue2',
        );
        $criteria->with = array('supplier', 'ubsinventory', 'import_routine');
        $criteria->together = true;
        $criteria->condition = 'item_status=0 and supplier.id=:sup_id';
        $criteria->params = array(
            ':sup_id' => $supid,
        );
        //$criteria->join = 'left join ';
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->compare('supplier.name', $this->sup_id, true);
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);
        $criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $criteria->compare('t.upc', $this->upc, true);
        $criteria->compare('t.mfg_name', $this->mfg_name, true);
        $criteria->compare('t.mfg_part_name', $this->mfg_part_name, true);
        $criteria->compare('`match`', $this->match);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.price-t.sup_price)',
                                'desc' => '(ubsinventory.price-t.sup_price) desc',
                            ),
                            'percent_diff' => array(
                                'asc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price',
                                'desc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price desc',
                            ),
                        ),
                        'defaultOrder' => 'testvalue desc,testvalue1 desc, testvalue2 desc',
                    ),
                ));
    }

    public function searchSupchecker()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.


        $criteria = new CDbCriteria;
        $criteria->together = true;
        $criteria->condition = 'item_status=0'; // and supplier.id=:sup_id';
        $criteria->select = array(
            '*',
        );

        if (!empty($this->mfg_part_name)) {
            $this->checkSearchType($criteria, 't.mfg_part_name', str_replace('*', '%', $this->mfg_part_name));
//            $criteria->addCondition('t.mfg_part_name like :mfg_part_name');
//            $criteria->params[':mfg_part_name'] = str_replace('*', '%', $this->mfg_part_name);
        }
        //$criteria->join = 'left join ';
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->with = array('ubsinventory', 'import_routine');
        if ($this->sup_id) {
            $criteria->with = array_merge($criteria->with, array('supplier'));
            
            
            //$criteria->compare('supplier.id', $this->sup_id);
            $criteria->compare('t.import_id', Tabs::model()->findByAttributes(array('supplier_id'=>$this->sup_id))->importRoutine->id);
            
        }
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);

        //$criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $this->checkSearchType($criteria, 't.mfg_sku', $this->mfg_sku);
        
        $this->checkSearchNumberic($criteria, 't.qty_total', $this->qty_total);

        //$criteria->compare('t.upc', $this->upc, true);
        $this->checkSearchType($criteria, 't.upc', $this->upc);

        //$criteria->compare('t.mfg_name', $this->mfg_name, true);
        $this->checkSearchType($criteria, 't.mfg_name', $this->mfg_name);

//		$criteria->compare('t.mfg_part_name',$this->mfg_part_name,true);
        $criteria->compare('`match`', $this->match);
        $criteria->compare('`match_by`', $this->match_by);
        //$criteria->compare('t.sup_price', $this->sup_price, true);
        $this->checkSearchType($criteria, 't.sup_price', $this->sup_price);

//		$criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price',$this->percent_diff);
        if ($this->percent_diff == 'n/a') {
//      $criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price', 0);
            $criteria->addCondition('abs(ubsinventory.price-t.sup_price)/ubsinventory.price IS NULL');
        } else {
            //$criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price', $this->percent_diff, true);
            $this->checkSearchType($criteria, 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price', $this->percent_diff);
        }

        //$criteria->compare('(ubsinventory.price-t.sup_price)', $this->price_diff, true);
        $this->checkSearchType($criteria, '(ubsinventory.price-t.sup_price)', $this->price_diff);

        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', 100),
                    ),
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'ubs_sku' => array(
                                'asc' => 'ubsinventory.sku',
                                'desc' => 'ubsinventory.sku DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.price-t.sup_price)',
                                'desc' => '(ubsinventory.price-t.sup_price) desc',
                            ),
                            'percent_diff' => array(
                                'asc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price',
                                'desc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price desc',
                            ),
                        ),
                    ),
                ));


        return $dataProvider;
    }
    
    public function searchSupchecker3()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->together = true;
        $criteria->condition = 'item_status=0'; // and supplier.id=:sup_id';
        $criteria->select = array(
            '*',
        );

        if (!empty($this->mfg_part_name)) {
            $this->checkSearchType($criteria, 't.mfg_part_name', str_replace('*', '%', $this->mfg_part_name));
//            $criteria->addCondition('t.mfg_part_name like :mfg_part_name');
//            $criteria->params[':mfg_part_name'] = str_replace('*', '%', $this->mfg_part_name);
        }
        //$criteria->join = 'left join ';
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->with = array('ubsinventory', 'import_routine');
        if ($this->sup_id) {
            $criteria->with = array_merge($criteria->with, array('supplier'));
            $criteria->compare('supplier.id', $this->sup_id);
        }
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);

        //$criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $this->checkSearchType($criteria, 't.mfg_sku', $this->mfg_sku);

        //$criteria->compare('t.upc', $this->upc, true);
        $this->checkSearchType($criteria, 't.upc', $this->upc);

        //$criteria->compare('t.mfg_name', $this->mfg_name, true);
        $this->checkSearchType($criteria, 't.mfg_name', $this->mfg_name);

//		$criteria->compare('t.mfg_part_name',$this->mfg_part_name,true);
        $criteria->compare('`match`', $this->match);
        $criteria->compare('`match_by`', $this->match_by);
        //$criteria->compare('t.sup_price', $this->sup_price, true);
        $this->checkSearchType($criteria, 't.sup_price', $this->sup_price);

//		$criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price',$this->percent_diff);
        if ($this->percent_diff == 'n/a') {
//      $criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price', 0);
            $criteria->addCondition('abs(ubsinventory.price-t.sup_price)/ubsinventory.price IS NULL');
        } else {
            //$criteria->compare('abs(ubsinventory.price-t.sup_price)/ubsinventory.price', $this->percent_diff, true);
            $this->checkSearchType($criteria, 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price', $this->percent_diff);
        }

        //$criteria->compare('(ubsinventory.price-t.sup_price)', $this->price_diff, true);
        $this->checkSearchType($criteria, '(ubsinventory.price-t.sup_price)', $this->price_diff);

        $count = self::model()->count($criteria);
        
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', 100),
                        'currentPage' => (isset($_POST['page']) ? ($_POST['page'] - 1) : 0),
                    ),
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'ubs_sku' => array(
                                'asc' => 'ubsinventory.sku',
                                'desc' => 'ubsinventory.sku DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.price-t.sup_price)',
                                'desc' => '(ubsinventory.price-t.sup_price) desc',
                            ),
                            'percent_diff' => array(
                                'asc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price',
                                'desc' => 'abs(ubsinventory.price-t.sup_price)/ubsinventory.price desc',
                            ),
                        ),
                    ),
                ));


        return array($dataProvider, $count);
    }
    
    protected function checkSearchNumberic($criteria, $field, $value)
    {
        if (!is_null($value)) {
            switch ($value) {
                case '1':
                    $criteria->condition .= " AND $field = 0";
                    break;
                case '2':
                    $criteria->condition .= " AND $field > 0";
                    break;
                case '3':
                    $criteria->condition .= " AND $field < 0";
                    break;
                case '4':
                    $criteria->condition .= " AND $field != 0";
                    break;
            }
        }
    }

    protected function checkSearchType($criteria, $field, $value)
    {
        if (isset($value[0]) && $value[0] == '^') {
            $string = substr($value, 1, strlen($value) - 1);
            $criteria->compare($field, '<>' . $string, true);
        } else {
            $criteria->compare($field, $value, true);
        }
    }

    public function searchNoMatch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('supplier', 'ubsinventory');
        $criteria->condition = 'item_status=2';
        $criteria->compare('id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->compare('supplier.name', $this->sup_id, true);
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);
        $criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $criteria->compare('t.upc', $this->upc, true);
        $criteria->compare('t.mfg_name', $this->mfg_name, true);
        $criteria->compare('t.mfg_part_name', $this->mfg_part_name, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.vprice-t.sup_price)',
                                'desc' => '(ubsinventory.vprice-t.sup_price) desc',
                            ),
                        ),
                    ),
                ));
    }

    public function searchImportedMatch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('supplier', 'ubsinventory');
        $criteria->condition = 'item_status=1';
        $criteria->compare('id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->compare('supplier.name', $this->sup_id, true);
        $criteria->compare('t.sup_vsku', $this->sup_vsku, true);
        $criteria->compare('t.sup_sku', $this->sup_sku, true);
        $criteria->compare('t.sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('t.sup_description', $this->sup_description, true);
        $criteria->compare('t.mfg_sku', $this->mfg_sku, true);
        $criteria->compare('t.upc', $this->upc, true);
        $criteria->compare('t.mfg_name', $this->mfg_name, true);
        $criteria->compare('t.mfg_part_name', $this->mfg_part_name, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                            'price_diff' => array(
                                'asc' => '(ubsinventory.vprice-t.sup_price)',
                                'desc' => '(ubsinventory.vprice-t.sup_price) desc',
                            ),
                        ),
                    ),
                ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('supplier');
        $criteria->together = true;
        $criteria->compare('id', $this->id);
        //$criteria->compare('import_id',$this->import_id);
        $criteria->compare('supplier.name', $this->sup_id, true);
        $criteria->compare('sup_vsku', $this->sup_vsku, true);
        $criteria->compare('sup_sku', $this->sup_sku, true);
        $criteria->compare('sup_sku_name', $this->sup_sku_name, true);
        $criteria->compare('sup_description', $this->sup_description, true);
        $criteria->compare('mfg_sku', $this->mfg_sku, true);
        $criteria->compare('upc', $this->upc, true);
        $criteria->compare('mfg_name', $this->mfg_name, true);
        $criteria->compare('mfg_part_name', $this->mfg_part_name, true);
        $criteria->compare('match', $this->match);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'sup_id' => array(
                                'asc' => 'supplier.name',
                                'desc' => 'supplier.name DESC',
                            ),
                        ),
                    ),
                ));
    }
    
    public function getMatchByStatus()
    {
        return isset($this->match_by_status[$this->match_by]) ? $this->match_by_status[$this->match_by] : '';
    }

}