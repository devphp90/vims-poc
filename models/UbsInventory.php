<?php

/**
 * This is the model class for table "{{combined_inventory_4}}".
 *
 * The followings are the available columns in table '{{combined_inventory_4}}':
 * @property integer $id
 * @property string $sku
 * @property string $sku_name
 * @property string $qoh
 * @property string $price
 */
class UbsInventory extends BaseAR
{
	public $sysid = 1;
	public $sup_count;
	public $m_buffer;
	public $cqoh;
	public $price_average;
	public $primary_supplier;
	public $primary_supplier_name;
	public $mark_up_sale_price;
	public $supplier_vqoh;
	public $supplier_map;
	public $sale_price;
	public $total_sup_count;
	public $total_qty_total;
	public $total_supplier_exclude;
	public $total_qoh_exclude;
	public $isCalculated = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return UbsCombinedInventory4 the static model class
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
		return '{{ubs_inventory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sku','required'),
			array('sku','unique'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('sku, sku_name,  mfg_web_site_url, sku_description, upc, mfg_name, mfg_part_name, mfg_title', 'safe'),
			array('oqoh,qoh, price, prim_sup, vqoh, vprice, user_price','safe'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sku, sku_name, qoh, price,vqoh,vprice,prim_sup,upc,mfg_name', 'safe', 'on'=>'search'),
		);
	}
	
	
	public function afterSave()
	{
		

		if(!$this->isCalculated){
			$this->calculate();
			$this->isCalculated = 1;
			$this->isNewRecord = false;
			$this->save();
		}
		
/*
		$model = UBSData::model()->findByAttributes(array('Sku'=>$this->sku));	
		
		if($model != null){
			$ubsModel = UbsInventory::model()->findByPk($this->id);
			
			if($ubsModel->primary_supplier_price_c != $model->PRICE || $ubsModel->mqoh_c != $model->QTY ){

				$model->PRICE = $ubsModel->primary_supplier_price_c;
				$model->QTY = $ubsModel->mqoh_c;
				$model->save(false);
			}
		}
*/
	}

  /**
   * Scope. Filter record by ubs_sku
   *
   * @param array $values
   */
  public function bySku($values)
  {
    return $this->byFieldValues('sku', $values);
  }

  public function calculate()
	{
		$row1 = Yii::app()->db->createCommand(array(
		    'select' => 'COALESCE(sup_id,0) as sup_id,COALESCE(gg.name,NULL) as sup_name,COALESCE(sup_price,0) as sup_price,COALESCE(uprice,0) as user_price,COALESCE(sup_bqoh,0) as sup_vqoh,COALESCE(sup_min_adv_price,0) as sup_min_adv_price,t.id',
		    'from' => "vims_sup_inventory as t",
		    'join'=>'left join vims_supplier as gg on t.sup_id = gg.id',
		    'where'=>"ubs_id = :ubs_id and primary_price_c = (select min(primary_price_c) from vims_sup_inventory as secsup left join vims_supplier on sup_id=vims_supplier.id where ubs_id = :ubs_id1 and vims_supplier.cancel_rate <= (select cancel_rate_limit from vims_system_info where id=1) and sup_bqoh>0 and secsup.sup_status=1 and secsup.item_status=1) and sup_status=1 and t.item_status=1 and gg.active=1",
		    'params' => array(
		    	':ubs_id'=>$this->id,
		    	':ubs_id1'=>$this->id,
		    ),
		))->queryRow();
		$this->primary_supplier_c = $row1['sup_id'];
		$this->primary_supplier_name_c = $row1['sup_name'];
		$this->primary_supplier_price_c = isset($row1['sup_price'])?$row1['sup_price']:sprintf("%.2f",0);
		$this->user_price = isset($row1['user_price'])?$row1['user_price']:sprintf("%.2f",0);
		
		$this->primary_supplier_map_c = isset($row1['sup_min_adv_price'])?$row1['sup_min_adv_price']:sprintf("%.2f",0);
		$supModel = SupInventory::model()->with('supplier')->findByPk($row1['id']);

		if($supModel != null)
			$this->primary_supplier_vqoh_c = $supModel->sup_vqoh_c;


		$this->vprice = $this->user_price != 0 ? $this->user_price : $this->primary_supplier_price_c;
		///////////////
		
		$row = Yii::app()->db->createCommand(array(

			    'select' => array('(SELECT COALESCE(count(distinct sup_id),0) as sup_qty FROM `vims_sup_inventory` WHERE ubs_id=:ubs_id1 and sup_status=1) as sup_qty,COALESCE(sum(qty),0) as qty_total,COALESCE(format(avg(sup_price),2),0.00) as price_avg'),
			    'from' => "(SELECT (select sum(qty_on_hand) from vims_sup_warehouse_item as g where g.vims_id = s.id) as qty,sup_price FROM vims_sup_inventory as s WHERE ubs_id=:ubs_id  and sup_status=1 and item_status=1) as a",
			    'params' => array(
			    	':ubs_id'=>$this->id,
			    	':ubs_id1'=>$this->id,
			    ),
			))->queryRow();
		$this->sup_count_c = $row['sup_qty'];
		$this->cqoh_c = $row['sup_qty']>1?$row['qty_total']:$this->primary_supplier_vqoh_c;
		$this->price_average_c = $row['price_avg'];
		$row = Yii::app()->db->createCommand(array(

			    'select' => array(' COALESCE(avg(primary_price_c),0.00) as price_avg'),
			    'from' => " vims_sup_inventory as s",
			    'where'=>'ubs_id=:ubs_id and sup_status=1 and item_status=1',
			    'params' => array(
			    	':ubs_id'=>$this->id,
			    ),
			))->queryRow();
		$this->price_average_c = $row['price_avg'];
		
		//sup_count>1?cqoh:supplier_vqoh  price_average(ok)
		/////
		if($this->sup_count_c > 1){
			$row = Yii::app()->db->createCommand(array(

				   	'where'=>':from >= `from` and :to<=`to` and sup_qty=:sup_qty and :start_qty>=`start_qty` and :end_qty<=`end_qty`',
					'select'=>'COALESCE(qty,0) as qty',
					'from'=>'vims_import_multisup_buffer_rule',
					'params'=>array(
						':sup_qty'=>$this->sup_count_c,
						':to'=>$this->price_average_c,
						':from'=>$this->price_average_c,
						':start_qty'=>$this->cqoh_c,
						':end_qty'=>$this->cqoh_c,
					),
			))->queryRow();
		}
		$this->mbuffer_c = isset($row['qty'])?$row['qty']:0;
		////
		$this->total_supplier_exclude_c = 0;
		$this->total_qoh_exclude_c = 0;
		$row = Yii::app()->db->createCommand(array(
		   	'where'=>'`start_price`<:start_price and `end_price` >=:end_price',
			'select'=>'percent',
			'from'=>'vims_ubs_percentage_rule',
			'params'=>array(
				':start_price'=>$this->vprice,
				':end_price'=>$this->vprice,
			),
		))->queryRow();
		if(isset($row['percent'])){
			$tolerent = $this->vprice* 0.01*$row['percent'];
			$row = Yii::app()->db->createCommand(array(
					'select'=>'COALESCE(count(distinct sup_id),0) as total_supplier_exclude',
				   	'where'=>'ubs_id=:ubs_id and (sup_price>:upper or sup_price<:lower) and sup_status=1 and item_status=1',
					'from'=>'vims_sup_inventory as sup_item',
					'params'=>array(
						':ubs_id'=>$this->id,
						':lower'=>$this->vprice-$tolerent,
						':upper'=>$this->vprice+$tolerent,
					),
			))->queryRow();
			$this->total_supplier_exclude_c = $row['total_supplier_exclude'];
		
			$row = Yii::app()->db->createCommand(array(
		
				   	'where'=>'ubs_id=:ubs_id and (sup_price>:upper or sup_price<:lower) and sup_status=1 and item_status=1',
					'select'=>'sum((select COALESCE(sum(qty_on_hand),0) as qty from vims_sup_warehouse_item where vims_id = sup_item.id)) as qty_minus',
					'from'=>'vims_sup_inventory as sup_item',
					'params'=>array(
						':ubs_id'=>$this->id,
						':lower'=>$this->vprice-$tolerent,
						':upper'=>$this->vprice+$tolerent,
					),
			))->queryRow();
			$this->total_qoh_exclude_c = $row['qty_minus'];
		}
		//mqoh
		if(($this->sup_count_c-$this->total_supplier_exclude_c)  == 1)
			$this->mqoh_c = $this->primary_supplier_vqoh_c;
		else if($this->sup_count_c>1)
			$this->mqoh_c =  $this->cqoh_c - $this->total_qoh_exclude_c - $this->mbuffer_c;
		else
			$this->mqoh_c = $this->cqoh_c;
		//
		
		$row = Yii::app()->db->createCommand(array(

			    'select' => array('(SELECT COALESCE(count(distinct sup_id),0) as sup_qty FROM `vims_sup_inventory` WHERE ubs_id=:ubs_id1) as total_sup_qty,COALESCE(sum(qty),0) as total_qty_total'),
			    'from' => "(SELECT (select sum(qty_on_hand) from vims_sup_warehouse_item as g where g.vims_id = s.id) as qty,sup_price FROM vims_sup_inventory as s WHERE ubs_id=:ubs_id) as a",
			    'params' => array(
			    	':ubs_id'=>$this->id,
			    	':ubs_id1'=>$this->id,
			    ),
			))->queryRow();
		$this->total_sup_count_c = $row['total_sup_qty'];
		$this->total_qty_total_c = $row['total_qty_total'];
		//
		$this->smarkup_c = NULL;
		if($this->primary_supplier_c != NULL){
			$row = Yii::app()->db->createCommand(array(
					
				    'where'=>'`to`>=:to and `from` <=:from and sup_id=:sup_id',
					'select'=>'markup,type',
					'from'=>'vims_import_sup_markup',
					'params'=>array(
						':to'=>$this->vprice,
						':from'=>$this->vprice,
						':sup_id'=>$this->primary_supplier_c,
					),
			))->queryRow();
			if(isset($row['markup']))
				$this->smarkup_c = $row['markup'].($row['type']?'%':'$');
		}
			
		//
		$this->gmarkup_c = NULL;
		$row = Yii::app()->db->createCommand(array(
				
			    'where'=>'`to`>=:to and `from` <=:from',
				'select'=>'markup,type',
				'from'=>'vims_import_markup',
				'params'=>array(
					':to'=>$this->vprice,
					':from'=>$this->vprice,
				),
		))->queryRow();
		
		if(isset($row['markup']))
			$this->gmarkup_c = $row['markup'].($row['type']?'%':'$');
		//
		$this->smarkupbreak_c = NULL;
		if($this->primary_supplier_c != NULL){
			$row = Yii::app()->db->createCommand(array(
					
				    'where'=>'`to`>=:to and `from` <=:from and sup_id=:sup_id',
					'select'=>'break_map',
					'from'=>'vims_import_sup_markup',
					'params'=>array(
						':to'=>$this->vprice,
						':from'=>$this->vprice,
						':sup_id'=>$this->primary_supplier_c,
					),
			))->queryRow();
			$this->smarkupbreak_c = $row['break_map'];
		}
		//
		

		$this->applymarkup_c = $this->smarkup_c?$this->smarkup_c:$this->gmarkup_c;
		
		$this->markupprice_c = 0;
		
		if(preg_match("/\%/", $this->applymarkup_c)){
			eval('$result ='.str_replace('%', '* 0.01', $this->applymarkup_c).'*'.$this->vprice.';');
			$this->markup_c = $result;
			if($this->smarkupbreak_c){
				$this->markupprice_c = sprintf('%.2f',$result+$this->vprice);
			}else{
				if($result > $this->primary_supplier_map_c)
					$this->markupprice_c = $this->primary_supplier_map_c;
				else
					$this->markupprice_c = sprintf('%.2f',$result+$this->vprice);
			}
			
		}else if(preg_match("/\\$/", $this->applymarkup_c)){

			eval('$result ='.str_replace('$', '+', $this->applymarkup_c).$this->vprice.';');
			$this->markup_c = $result;
			if($this->smarkupbreak_c)
				$this->markupprice_c = sprintf('%.2f',$result);
			else{
				if($result > $this->primary_supplier_map_c)
					$this->markupprice_c = $this->primary_supplier_map_c;
				else
					$this->markupprice_c = sprintf('%.2f',$result);
			}
		}else{
			$this->markupprice_c = $this->vprice;
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'prim_sup'),
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
			'sup_inventory'=>array(self::HAS_MANY, 'SupInventory', 'ubs_id'),
			'system_info'=>array(self::HAS_ONE, 'SystemInfo',array('id'=>'sysid')),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mfg_title'=>'Mfg Name',
			'sku' => 'UBS SKU',
			'sku_name' => 'UBS SKU Name',
			'qoh' => 'Qty Total',
			'oqoh'=>'oQOH',
			'vqoh'=>'multiSup QTY',
			'price' => 'UBS Cost',
			'mfg_name'=>'MPN',
			'mfg_part_name'=>'Manufacturer Part # (Plain)',
			'upc'=>'UPC',
			'prim_sup'=>'Primary Supplier',
			'vprice'=>'UBS Sale Price',
			'markup_c'=>'Markup',
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
//		$criteria->with = array('sup_inventory.supplier','sup_inventory');
	

		$criteria->compare('id',$this->id);
//		$criteria->compare('sku',$this->sku);
		$criteria->compare('upc',$this->upc);
		$criteria->compare('sku_name',$this->sku_name,true);
/*
		$criteria->compare('qoh',$this->qoh,true);
		$criteria->compare('price',$this->price,true);
		
		$criteria->compare('t.mfg_name',$this->mfg_name,true);

		$criteria->compare('vqoh',$this->price,true);
		$criteria->compare('vprice',$this->price,true);
		$criteria->compare('prim_sup',$this->price,true);
*/

    if (strpos($this->sku, '*') !== false) {
      $sku = str_replace('*', '%', $this->sku);
      $criteria->addCondition("sku LIKE '{$sku}'");
    } else {
      $criteria->compare('sku',$this->sku, true);
    }
		
		/*$row = Yii::app()->db->createCommand(array(
			    'select' => array('max(id) as itemnumber'),
			    'from' => "vims_ubs_inventory",
			))->queryRow();
		*/
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			'sort'=>array(
				'defaultOrder'=>'sku',
			),
			'pagination'=>array('pageSize'=>100),
			//'totalItemCount'=>$row['itemnumber'], //Bad code
		));


	}
	
	
	public function boundsearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		$criteria=new CDbCriteria;
		$criteria->with = array('sup_inventory.supplier','sup_inventory');
	

		$criteria->compare('id',$this->id);
		$criteria->compare('sku',$this->sku);
		$criteria->compare('upc',$this->upc);
//		$criteria->compare('sku_name',$this->sku_name,true);
/*
		$criteria->compare('qoh',$this->qoh,true);
		$criteria->compare('price',$this->price,true);
		
		$criteria->compare('t.mfg_name',$this->mfg_name,true);

		$criteria->compare('vqoh',$this->price,true);
		$criteria->compare('vprice',$this->price,true);
		$criteria->compare('prim_sup',$this->price,true);
*/
		
		
		
		$row = Yii::app()->db->createCommand(array(

			    'select' => array('max(id) as itemnumber'),
			    'from' => "vims_ubs_inventory",
			))->queryRow();
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			'sort'=>array(
				'defaultOrder'=>'sku',
			),
			'pagination'=>array('pageSize'=>10),
			'totalItemCount'=>$row['itemnumber'],
		));


	}
}