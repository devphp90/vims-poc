<?php

class Update
{
	private $_tabsModel;
	private $_routineModel;
	private $_updateLogModel;
	public $time;

	private $_countInstock = 0;

	private $_diffPriceCount = 0;
	private $_diffQOHCount = 0;

	private $_dbcommand;
	
	private function dev($message) {
		echo $message. "<br/>";
	}
	
	
	function __construct($tabid)
	{
		
		$this->init($tabid);

		$this->run();
		
	}
	
	public function init($tabid)
	{
		$this->dev("Find tabsModel");
		$this->_tabsModel = Tabs::model()->find(array(
			'condition'=>'t.id=:id',
			'params'=>array(
				':id'=>$tabid,
			),
			'with'=>array(
				'supplier',
				'importRoutine'=>array(
					'select'=>'id,sup_id,ware_1,ware_2,ware_3,ware_4,ware_5,ware_6,ware_id_1,ware_id_2,ware_id_3,ware_id_4,ware_id_5,ware_id_6',
					'with'=>array(
						'supplier'=>array('alias'=>'sup'),
						'update',
					),
				),
			),
		));	
		


		if($this->_tabsModel == null)
			throw new CHttpException('500','Can\'t find Tabs id.');
			
		$this->dev("TabModel found".$this->_tabsModel->id);
		
		$this->_updateLogModel = new TabsUpdateLog;
		
		$this->_updateLogModel->tabs_id = $this->_tabsModel->id;

		if(!$this->_updateLogModel->save())
			throw new CHttpException('500','Can\'t create Import Log.');
			
		$this->_routineModel = $this->_tabsModel->importRoutine;

		$this->_updateModel = $this->_routineModel->getUpdateModel();


		$this->_dbcommand = Yii::app()->db->createCommand();
		$this->_dbcommand->delete('vims_import_warnitem_price', 'import_id=:id', array(':id'=>$this->_routineModel->id));
		$this->_dbcommand->delete('vims_import_warnitem_qty', 'import_id=:id', array(':id'=>$this->_routineModel->id));


	}
	
	public function run()
	{

		$this->updateStatus('data_integrity',1);

		
		if($this->_tabsModel->supplier->active == 0 )
			$this->updateLog('data_integrity','Supplier is Inactive',true);

		$this->checkDiffPercent();

		$this->updateStatus('data_integrity',3);

		$this->updateStatus('instock_item',1);

		$this->checkInstockItem();

		$this->updateStatus('instock_item',3);
		
		$this->updateStatus('qoh_percent_change',3);

		$this->updateStatus('price_percent_change',3);


		$this->markUpdateItem();

		if(empty($this->_updateLogModel->price_percent_change_reason))
			$this->updateStatus('price_percent_change',3);
		else
			$this->updateStatus('price_percent_change',4);
		
		if(empty($this->_updateLogModel->qoh_percent_change_reason))
			$this->updateStatus('qoh_percent_change',3);
		else
			$this->updateStatus('qoh_percent_change',4);
			


		$this->dropItem();
		
		$this->_updateLogModel->finish_time = date("Y-m-d H:i:s");
		$this->_updateLogModel->item = $this->_countInstock;

		$this->_updateLogModel->save();
		
	}
	
	public function checkDiffPercent()
	{

		$sql = 'select count(*) as diffPriceCount from vims_import_vsheet as a right join vims_import_vsheet_last as b on a.sup_vsku = b.sup_vsku and a.import_id = b.import_id where a.price != b.price and a.import_id= :import_id';
		$command = Yii::app()->db->createCommand($sql); 

		$import_id = $this->_routineModel->id;
		$command->bindParam(":import_id",$import_id);
		$result = $command->queryRow();
		$this->_diffPriceCount = $result['diffPriceCount'];
		
		$sql = 'select count(*) as diffQOHCount from vims_import_vsheet as a right join vims_import_vsheet_last as b on a.sup_vsku = b.sup_vsku and a.import_id = b.import_id where (a.ware_1+a.ware_2+a.ware_3+a.ware_4+a.ware_5+a.ware_6) != (b.ware_1+a.ware_2+b.ware_3+b.ware_4+b.ware_5+b.ware_6) and a.import_id= :import_id';
		$command = Yii::app()->db->createCommand($sql); 

		$command->bindParam(":import_id",$import_id);
		$result = $command->queryRow(); 
		$this->_diffQOHCount = $result['diffQOHCount'];
		
		$sql = 'select count(*) as countInstock from vims_import_vsheet as a right join vims_sup_inventory as b on a.sup_vsku = b.sup_vsku and a.sup_id = b.sup_id where a.sup_id = :sup_id and (b.buffer_c + (a.ware_1+a.ware_2+a.ware_3+a.ware_4+a.ware_5+a.ware_6) - b.sup_open_order) > 0';
		//select count(*) as countInstock from vims_import_vsheet as a right join vims_sup_inventory as b on a.sup_vsku = b.sup_vsku where a.sup_id = :sup_id and (b.buffer_c + (a.ware_1+a.ware_2+a.ware_3+a.ware_4+a.ware_5+a.ware_6) - b.sup_open_order) > 0
		$command = Yii::app()->db->createCommand($sql); 
		$supid = $this->_routineModel->supplier->id;
		$command->bindParam(":sup_id",$supid);

		$result = $command->queryRow();
		$this->_countInstock = $result['countInstock'];
/*
		$pageSize = 5000;
		$count = ImportVsheet::model()->count('import_id=?',array($this->_routineModel->id));
		
		$page = ceil($count/$pageSize);



		for($i=0;$i<$page;$i++){
			$vsheets = ImportVsheet::model()->findAll(array(
				'condition' => 'import_id=:import_id',
		    	'params' => array(
					':import_id'=>$this->_routineModel->id,
				)
			));
			

			$dataProvider_1=new CActiveDataProvider('ImportVsheet', array(
			    'criteria'=>array(
					'select'=>'(ware_1+ ware_2 + ware_3 + ware_4 + ware_5 + ware_5) as totalQOH,sup_vsku,price',
			    ),
			    'pagination'=>array(
			        'pageSize'=>$pageSize,
			        'currentPage'=>$i,
			    ),
			));
			
			foreach($dataProvider_1->getData() as $id=>$vsheet):
				$totalQOH = $vsheet->totalQOH;


select count(*) as diffQOHCount from vims_import_vsheet as a right join vims_sup_inventory as b on a.sup_vsku = b.sup_vsku and b.sup_id = ? where (b.buffer_c + (a.ware_1+a.ware_2+a.ware_3+a.ware_4+a.ware_5+a.ware_6) - b.sup_open_order) > 0




				$model = ImportVsheetLast::model()->findbyAttributes(array(
					'sup_vsku'=>$vsheet->sup_vsku,
					'import_id'=>$this->_routineModel->id,
				));

				if($model!=null){//ok
					if($vsheet->price != $model->price)
						$this->_diffPriceCount++;
						
					$totalQOHOld = 0;
					for($a=1;$a<=6;$a++)
						$totalQOHOld+= $model->{'ware_'.$a};
						
					if($totalQOHOld != $totalQOH)//ok
						$this->_diffQOHCount++;
				}
				
				$supItem = SupInventory::model()->findByAttributes(array(
					'sup_id'=>$this->_routineModel->supplier->id,
					'sup_vsku'=>$vsheet->sup_vsku,
				));
				
				if($supItem != null){

					$supbQOH = $totalQOH + $supItem->getBuffer();
					$supvQOH = $supbQOH  - $supItem->sup_open_order;
					
					if($supvQOH > 0)
						$this->_countInstock++;
				}
				
			endforeach;
			
		}
*/
		
		
			
		

		$lastItemCount = ImportVsheetLast::model()->count('import_id=:import_id',array(
			':import_id'=>$this->_routineModel->id,
		));
		

		$diPricePercent = isset($this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->di_price_percent)?
								$this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->di_price_percent:
								$this->_routineModel->update->getGlobalQaModel()->di_price_percent;
								
		if($diPricePercent != null){
			
			$diPricePercentCount = $lastItemCount * 0.01 * $diPricePercent;

			if($this->_diffPriceCount > $diPricePercentCount && $diPricePercentCount != 0)
				$this->updateLog('data_integrity',
					'DI Price Percent rule: '.$diPricePercent.', '.
					'limit changed item:'.$diPricePercentCount.', '.
					'current changed item:'.$this->_diffPriceCount,true
				);
		}
		

		$diQOHPercent = isset($this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->di_qoh_percent)?
								$this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->di_qoh_percent:
								$this->_routineModel->update->getGlobalQaModel()->di_qoh_percent;

		if($diQOHPercent != null){
		
			$diQOHPercentCount = $lastItemCount * 0.01 * $diQOHPercent;
			
			if($this->_diffQOHCount > $diQOHPercentCount && $diQOHPercentCount !=0)
				$this->updateLog('data_integrity',
					'DI QOH Percent rule: '.$diQOHPercent.', '.
					'limit changed item:'.$diQOHPercentCount.', '.
					'current changed item:'.$this->_diffQOHCount,true
				);	
		}

	}
	
	public function markUpdateItem()
	{
		$this->time = Yii::getLogger()->getExecutionTime();

    // Purge checkers table
	    SupItemsNewManage::model()->deleteAll('import_id = :import_id and `match`<>:match',array(
	    	':import_id' => $this->_routineModel->id,
	    	':match' => SupItemsNewManage::MATCH_STATUS_UNDECIDED,
	    ));
	    
	    $this->_updateLogModel->vsheet_item = $this->_updateLogModel->importlog->item;
		$this->_updateLogModel->save();
	

		
		
		

		$pageSize = 100;
		//  and not exists(select 1 from vims_sup_items_new_no_match as a where a.sup_vsku = t.sup_vsku and a.sup_id = :sup_id)
		$count = ImportVsheet::model()->count('import_id=:import_id',array(
			':import_id'=>$this->_routineModel->id,
			//':sup_id'=>$this->_routineModel->sup_id

		));

		$page = ceil($count/$pageSize);

		
		$criteria = new CDbCriteria;
		//$criteria->condition = 'import_id=:import_id and not exist(select 1 from vims_sup_items_new_manage as b where b.sup_vsku = t.sup_vsku and b.import_id = t.import_id) and not exist(select 1 from vims_sup_items_new_no_match as a where a.sup_vsku = t.sup_vsku and a.sup_id = :sup_id)';

		$criteria->select = '(t.ware_1+t.ware_2+t.ware_3+t.ware_4+t.ware_5+t.ware_6) as totalQOH,t.*';
		//$criteria->condition = ' import_id=:import_id  and not exists(select 1 from vims_sup_items_new_no_match as a where a.sup_vsku = t.sup_vsku and a.sup_id = :sup_id)';
		$criteria->condition = 'import_id=:import_id';
//		$criteria->join = 'LEFT JOIN vims_sup_items_new_no_match AS a ON a.sup_vsku = t.sup_vsku AND a.sup_id =  :sup_id';
		$criteria->params = array(
			':import_id'=>$this->_routineModel->id,
			//':sup_id'=>$this->_routineModel->sup_id,
		);
		$criteria->with = array(
			'supInventory'=>array(

			),



		);
		$aaaaa = 0;
		$finish_item = 0;
		$instock_item = 0;
		$already_checker_item = 0;





		for($i=0;$i<$page;$i++){
			
			$dataProvider_1=new CActiveDataProvider('ImportVsheet', array(
			    'criteria'=>$criteria,
			    'pagination'=>array(
			        'pageSize'=>$pageSize,
			        'currentPage'=>$i,
			    ),
			    'totalItemCount'=>$count,
			));

			$importVsheets = $dataProvider_1->getData();
			foreach($importVsheets as $id=>$vsheet):

			




/*tuned

// Skip those from sup_items_new_no_match
        if (SupItemsNewNoMatch::model()->findByAttributes(array(
          'sup_id'=>$this->_routineModel->supplier->id,
          'sup_vsku'=>$vsheet->sup_vsku,
        )))
          continue;

        // Skip those already in checkers
        if (SupItemsNewManage::model()->findByAttributes(array(
          'sup_vsku' => $vsheet->sup_vsku,
          'import_id' => $this->_routineModel->id,
        )))
          continue;
*/
			


/*		


			$supItem = SupInventory::model()->with('supplier','ubs_inventory')->findByAttributes(array(
						'sup_id'=>$this->_routineModel->supplier->id,
						'sup_vsku'=>$vsheet->sup_vsku,
					));

*/
			$supItem = $vsheet->supInventory;
			


			if($supItem != null){




				$totalQOH = $vsheet->totalQOH;
				

				$supbQOH = $totalQOH + $supItem->getBuffer();
				
				$supvQOH = $supbQOH  - $supItem->sup_open_order;


				foreach($vsheet->supInventory->warehouseitems as $ware_id=>$ware_value){	

					for($a=1;$a<=6;$a++):

						if(!empty($this->_routineModel->{'ware_'.$a}) && 
							$ware_value->ware_id == $this->_routineModel->{'ware_id_'.$a} &&
							$ware_value->qty_on_hand != $vsheet->{'ware_'.$a}
							){
								$ware_value->qty_on_hand = $vsheet->{'ware_'.$a};
								$ware_value->save(false);
						}
					endfor;
				}

				/*
for($a=1;$a<=6;$a++):

				
				for($a=1;$a<=6;$a++):

					if($this->_routineModel->{'ware_'.$a}){
						$supWareItem = SupWarehouseItem::model()->findByAttributes(array(
							'vims_id'=>$supItem->id,
							'ware_id'=>$this->_routineModel->{'ware_id_'.$a},
						));
						
						if($supWareItem != null){

							$supWareItem->qty_on_hand = $vsheet->{'ware_'.$a};
							$supWareItem->save();
						}
					}
				endfor;

*/





				$supItem->last_update = date("Y-m-d H:i:s");
				$supItem->sup_price = $vsheet->price;
				$supItem->sup_min_adv_price = $vsheet->map;
				$supItem->mfg_sku_name = $vsheet->mfg_part_name;
				$supItem->sup_bqoh = $supbQOH;
				$supItem->sup_vqoh = $supvQOH;
					

				if($totalQOH > 0){

				


					$supItem->sup_status = SupInventory::STATUS_IN_STOCK;
								
					$this->checkQPPercent($supItem->sup_vsku, 'Price',$vsheet->price);

					$this->checkQPPercent($supItem->sup_vsku, 'QOH',$totalQOH);

					
					$supItem->save(false);
					
				}else
					$supItem->saveBO($this->_routineModel->days_to_disco);
					
				


				$data = $vsheet->attributes;
				unset($data['id']);
				unset($data['sup_sku']);
				$this->_dbcommand->insert('vims_import_vsheet_last', $data);
				
				if($supItem->ubs_inventory !== null)
					$supItem->ubs_inventory->save(false);
					
				$instock_item += 1;

				if($instock_item %100 ==0)
					$this->_updateLogModel->saveCounters(array('instock_item'=>100));
					
				unset($vsheet);
				unset($importVsheets[$id]);




			}else{
				if (!SupItemsNewManage::model()->findByAttributes(array(
		            'sup_vsku' => $vsheet->sup_vsku,
		            'import_id' => $vsheet->import_id,
		            'match' => SupItemsNewManage::MATCH_STATUS_UNDECIDED
		          ))) {


		            $matchedUbsItems = array();
		            
		            $supItems = SupInventory::model()->findAll(array(
		            	'select'=>'ubs_id',
						'condition'=>"sup_vsku = :vsku and sup_vsku!=''", 
						'params'=>array(
							':vsku' => strtolower(trim($vsheet->sup_vsku)),
						),
						'with'=>array('supplier','ubs_inventory'),
					));

		            foreach ($supItems as $item) {
						$newItem = new SupItemsNewManage;
						$newItem->import_id = $this->_routineModel->id;
						$newItem->mfg_sku = $vsheet->mfg_sku;
						$newItem->upc = $vsheet->upc;
						$newItem->mfg_name = $vsheet->mfg_name;
						$newItem->mfg_part_name = $vsheet->mfg_part_name;
						$newItem->sup_sku_name = $vsheet->sup_sku_name;
						$newItem->sup_vsku = $vsheet->sup_vsku;
						$newItem->sup_price = $vsheet->price;
						$newItem->match_by = SupItemsNewManage::MATCH_VSKU;
						$newItem->match_ubs_id = $item->ubs_id;
						$newItem->save();
						$matchedUbsItems[] = $item->ubs_id;
						$this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }
		            


		            if(count($matchedUbsItems) > 0){
						$finish_item += 1;
			            if($finish_item %1000 ==0)
							$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));
		            	continue;
		            }





		            	
		            	
		            $ubsItems = UbsInventory::model()->findAll(
		            	"upc=:upc and mfg_name=:mfg_name and mfg_title=:mfg_title and upc!='' and mfg_name!='' and mfg_title !=''",
		            	array(
		                  ':upc' => $vsheet->upc,
		                  ':mfg_name' => $vsheet->mfg_sku,
		                  ':mfg_title' => $vsheet->mfg_name,
		            ));
		            foreach ($ubsItems as $item) {
	
		              $newItem = new SupItemsNewManage;
		              $newItem->import_id = $this->_routineModel->id;
		              $newItem->mfg_sku = $vsheet->mfg_sku;
		              $newItem->upc = $vsheet->upc;
		              $newItem->mfg_name = $vsheet->mfg_name;
		              $newItem->mfg_part_name = $vsheet->mfg_part_name;
		              $newItem->sup_sku_name = $vsheet->sup_sku_name;
		              $newItem->sup_vsku = $vsheet->sup_vsku;
		              $newItem->sup_price = $vsheet->price;
		              $newItem->match_by = SupItemsNewManage::MATCH_MPN_UPC_NAME;
		              $newItem->match_ubs_id = $item->id;
		              $newItem->save();
		              $matchedUbsItems[] = $item->id;
		              $this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }



		           if(count($matchedUbsItems) > 0){
						$finish_item += 1;
			            if($finish_item %1000 ==0)
							$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));
		            	continue;
		            }
		            

		            	

		            $ubsItems = UbsInventory::model()->findAll(
		            	"upc=:upc and mfg_name=:mfg_name and upc!='' and mfg_name !=''",
						array(
			              ':upc' => $vsheet->upc,
			              ':mfg_name' => $vsheet->mfg_sku,
		            ));
		            foreach ($ubsItems as $item) {
						$newItem = new SupItemsNewManage;
						$newItem->import_id = $this->_routineModel->id;
						$newItem->mfg_sku = $vsheet->mfg_sku;
						$newItem->upc = $vsheet->upc;
						$newItem->mfg_name = $vsheet->mfg_name;
						$newItem->mfg_part_name = $vsheet->mfg_part_name;
						$newItem->sup_sku_name = $vsheet->sup_sku_name;
						$newItem->sup_vsku = $vsheet->sup_vsku;
						$newItem->sup_price = $vsheet->price;
						$newItem->match_by = SupItemsNewManage::MATCH_MPN_UPC;
						$newItem->match_ubs_id = $item->id;
						$newItem->save();
						$matchedUbsItems[] = $item->id;
						$this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }
		            

/*
		            if(count($matchedUbsItems) > 0)
		            	continue;
*/


		            	
		            $ubsItems = UbsInventory::model()->findAll(
		            	"mfg_title=:mfg_title and mfg_name=:mfg_name and mfg_title!='' and mfg_name!=''",
						array(
							':mfg_title' => $vsheet->mfg_name,
							':mfg_name' => $vsheet->mfg_sku,
		            ));
		            foreach ($ubsItems as $item) {
	
		              $newItem = new SupItemsNewManage;
		              $newItem->import_id = $this->_routineModel->id;
		              $newItem->mfg_sku = $vsheet->mfg_sku;
		              $newItem->upc = $vsheet->upc;
		              $newItem->mfg_name = $vsheet->mfg_name;
		              $newItem->mfg_part_name = $vsheet->mfg_part_name;
		              $newItem->sup_sku_name = $vsheet->sup_sku_name;
		              $newItem->sup_vsku = $vsheet->sup_vsku;
		              $newItem->sup_price = $vsheet->price;
		              $newItem->match_by = SupItemsNewManage::MATCH_MPN_NAME;
		              $newItem->match_ubs_id = $item->id;
		              $newItem->save();
		              $matchedUbsItems[] = $item->id;
		              $this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }
					

					if(count($matchedUbsItems) > 0){
						$finish_item += 1;
			            if($finish_item %1000 ==0)
							$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));
		            	continue;
		            }


		            	
					$ubsItems = UbsInventory::model()->findAll("upc=:upc and upc!=''",array(
		              'upc' => $vsheet->upc,
		            ));
					foreach ($ubsItems as $item) {
		
						$newItem = new SupItemsNewManage;
						$newItem->import_id = $this->_routineModel->id;
						$newItem->mfg_sku = $vsheet->mfg_sku;
						$newItem->upc = $vsheet->upc;
						$newItem->mfg_name = $vsheet->mfg_name;
						$newItem->mfg_part_name = $vsheet->mfg_part_name;
						$newItem->sup_sku_name = $vsheet->sup_sku_name;
						$newItem->sup_vsku = $vsheet->sup_vsku;
						$newItem->sup_price = $vsheet->price;
						$newItem->match_by = SupItemsNewManage::MATCH_UPC;
						$newItem->match_ubs_id = $item->id;
						$newItem->save();
						$matchedUbsItems[] = $item->id;
						$this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }
		            

					if(count($matchedUbsItems) > 0){
						$finish_item += 1;
			            if($finish_item %1000 ==0)
							$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));
		            	continue;
		            }


		            	

		            	
		            $ubsItems = UbsInventory::model()->findAll("mfg_name=:mfg_name and mfg_name=''",array(
		              'mfg_name' => $vsheet->mfg_sku,
		            ));
		            foreach ($ubsItems as $item) {
	
						$newItem = new SupItemsNewManage;
						$newItem->import_id = $this->_routineModel->id;
						$newItem->mfg_sku = $vsheet->mfg_sku;
						$newItem->upc = $vsheet->upc;
						$newItem->mfg_name = $vsheet->mfg_name;
						$newItem->mfg_part_name = $vsheet->mfg_part_name;
						$newItem->sup_sku_name = $vsheet->sup_sku_name;
						$newItem->sup_vsku = $vsheet->sup_vsku;
						$newItem->sup_price = $vsheet->price;
						$newItem->match_by = SupItemsNewManage::MATCH_MPN;
						$newItem->match_ubs_id = $item->id;
						$newItem->save();
						$matchedUbsItems[] = $item->id;
						$this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }

					if(count($matchedUbsItems) > 0){
						$finish_item += 1;
			            if($finish_item %1000 ==0)
							$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));
		            	continue;
		            }



		            if (empty($matchedUbsItems)) {
						$newItem = new SupItemsNewManage;
						$newItem->import_id = $this->_routineModel->id;
						$newItem->mfg_sku = $vsheet->mfg_sku;
						$newItem->upc = $vsheet->upc;
						$newItem->mfg_name = $vsheet->mfg_name;
						$newItem->mfg_part_name = $vsheet->mfg_part_name;
						$newItem->sup_sku_name = $vsheet->sup_sku_name;
						$newItem->sup_vsku = $vsheet->sup_vsku;
						$newItem->sup_price = $vsheet->price;
						$newItem->match_by = 0;
						$newItem->match_ubs_id = 0;
						$newItem->save();
						$this->_updateLogModel->saveCounters(array('checker_item'=>1));
		            }
				}else{
					 $already_checker_item += 1;
					 $this->_updateLogModel->saveCounters(array('already_checker_item'=>1));

				} // undecided items

			}
				




			$finish_item += 1;
//$this->_updateLogModel->saveCounters(array('finish_item'=>1));
			if($finish_item %1000 ==0)
				$this->_updateLogModel->saveCounters(array('finish_item'=>+1000));


			endforeach;
		}
		
		$this->_updateLogModel->instock_item = $instock_item;
		$this->_updateLogModel->finish_item = $finish_item;
		$this->_updateLogModel->save(false);

				
		

	}
	
	
	public function checkQPPercent($sku, $val, $data)
	{
		$model = ImportVsheetLast::model()->findbyAttributes(array(
			'sup_vsku'=>$sku,
			'import_id'=>$this->_routineModel->id,
		));
		
		if($model != null){

			switch($val){
				case 'Price':
					$this->checkPrice($sku, $data, $model->price);
					break;
				case 'QOH':
					$totalQOH = $model->ware_1 + 
								$model->ware_2 + 
								$model->ware_3 + 
								$model->ware_4 + 
								$model->ware_5 + 
								$model->ware_6;

					$this->checkQOH($sku, $data, $totalQOH);
					break;
				default:
			}
		}
		
	}
	
	

	public function dropItem()
	{
		$criteria=new CDbCriteria();
		$criteria->condition = 'sup_id=:sup_id and sup_vsku not in (select sup_vsku from vims_import_vsheet where import_id=:import_id)';
		$criteria->params = array(
			':sup_id'=>$this->_routineModel->sup_id,
			':import_id'=>$this->_routineModel->id,
		);
		$criteria->select= '1';
		$pageSize = 100;
		$count = ImportVsheet::model()->count($criteria);

		$page = ceil($count/$pageSize);
		
		
		for($i=0;$i<$page;$i++){
			
			$dataProvider_1=new CActiveDataProvider('SupInventory', array(
			    'criteria'=>array(
			    	'condition'=>'sup_id=:sup_id and sup_vsku not in (select sup_vsku from vims_import_vsheet where import_id=:import_id)',
			    	'params'=>array(
			    		':sup_id'=>$this->_routineModel->sup_id,
						':import_id'=>$this->_routineModel->id,
			    	),
			    	'with'=>array(
			    		'supplier',
			    		'ubs_inventory'
			    	),
			    ),
			    'pagination'=>array(
			        'pageSize'=>$pageSize,
			        'currentPage'=>$i,
			    ),
			    'totalItemCount'=>$count,
			));

			$importVsheets = $dataProvider_1->getData();
			foreach($importVsheets as $id=>$supitem):
				$supitem->sup_drop = 1;
				$this->_updateLogModel->drop_items .= 'Sup vSKU:'.$supitem->sup_vsku.'<br/>';
				$this->_updateLogModel->saveCounters(array('drop_items'=>1));
				$supitem->sup_status = SupInventory::STATUS_MISSING;
				$supitem->qty_total_c = 0; // reset total
				$supitem->save();


				if (!$model = SupItemsMissing::model()->findByPk($supitem->id))
					$model = new SupItemsMissing;
				$model->attributes = $supitem->attributes;
				$model->sup_status = SupItemsMissing::STATUS_MISSING;
				$model->save();
			endforeach;
		}
		
/*
		$dropItem = SupInventory::model()->with('supplier','ubs_inventory')->findAll($criteria);
		
		foreach($dropItem as $id=>$supitem){
			$supitem->sup_drop = 1;
			$this->_updateLogModel->drop_items .= 'Sup vSKU:'.$supitem->sup_vsku.'<br/>';
			$this->_updateLogModel->saveCounters(array('drop_items'=>1));
      $supitem->sup_status = SupInventory::STATUS_MISSING;
      $supitem->qty_total_c = 0; // reset total
      $supitem->save();
//			$supitem->saveBO($this->_routineModel->days_to_disco);

      if (!$model = SupItemsMissing::model()->findByPk($supitem->id))
        $model = new SupItemsMissing;
      $model->attributes = $supitem->attributes;
      $model->sup_status = SupItemsMissing::STATUS_MISSING;
      $model->save();
		}
*/
	}

	public function checkQOH($sku, $currentQOH, $lastQOH)
	{
		$qohPercent = isset($this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->qoh_percent)?
								$this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->qoh_percent:
								$this->_routineModel->update->getGlobalQaModel()->qoh_percent;
		
		if($qohPercent == null)
			return true;

			
		$tolerant =  $lastQOH * 0.01 * $qohPercent;

		if($currentQOH < abs($tolerant-$lastQOH) || $currentQOH > $tolerant+$lastQOH){
			$vsheet = ImportVsheet::model()->findByAttributes(array(
				'import_id'=>$this->_routineModel->id,
				'sup_vsku'=>$sku
			));
			
			$warnItem = new ImportWarnitemQty;
			
			unset($vsheet->id);
			$warnItem->attributes = $vsheet->attributes;
			$warnItem->qty = $currentQOH;
			$warnItem->lastqty = $lastQOH;
			$warnItem->save(false);
			$this->updateLog('qoh_percent_change',
				'Sup item SKU: '.$sku.', '.
				'Percent rule: '.$qohPercent.', '.
				'previous:'.$lastQOH.', '.
				'current:'.$currentQOH
			);
		}
	}
	public function checkPrice($sku, $currentPrice, $lastPrice)
	{





		$pricePercent = isset($this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->price_percent)?
								$this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->price_percent:
								$this->_routineModel->update->getGlobalQaModel()->price_percent;

		if($pricePercent == null)
			return true;
				
		$tolerant =  $lastPrice * 0.01 * $pricePercent;

		if($currentPrice < abs($tolerant-$lastPrice) || 
					$currentPrice > $tolerant+$lastPrice){
			$vsheet = ImportVsheet::model()->findByAttributes(array(
				'import_id'=>$this->_routineModel->id,
				'sup_vsku'=>$sku
			));
			
			$warnItem = new ImportWarnitemPrice;
			
			unset($vsheet->id);
			$warnItem->attributes = $vsheet->attributes;
			$warnItem->last_price = $lastPrice;
			$warnItem->save(false);
			$this->updateLog('price_percent_change',
				'Sup item SKU: '.$sku.', '.
				'Percent rule: '.$pricePercent.', '.
				'previous:'.$lastPrice.', '.
				'current:'.$currentPrice
			);
		}
	}

	
	public function updateStatus($step,$status)
	{
		$this->_updateLogModel->{$step.'_status'} = $status;
		$this->_updateLogModel->save();
	}
	
	public function updateLog($step,$reason = '',$isFatal = false)
	{
		$this->_updateLogModel->{$step.'_reason'} .= $reason.'<br/>';
		if($isFatal == true){
			$this->_tabsModel->supplier->active = 0;
			$this->_tabsModel->supplier->save();
			$this->_updateLogModel->{$step.'_status'} = 2;
			$this->_updateLogModel->save();
			exit;
		}else
			$this->_updateLogModel->save();
	}

	
	public function checkInstockItem()
	{
	
	

		$itemChange = isset($this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->instock_percent)?



								$this->_routineModel->update->getSupplierQaModel($this->_routineModel->sup_id)->instock_percent:
								$this->_routineModel->update->getGlobalQaModel()->instock_percent;
							

		if($this->_tabsModel->instock_item != 0 && $itemChange !== NULL){

			$tolerant = $this->_countInstock * 0.01 * $itemChange;
			
			if($this->_countInstock < abs($tolerant-$this->_tabsModel->instock_item) || 
					$this->_countInstock > $tolerant+$this->_tabsModel->instock_item)
					
				$this->updateLog('instock_item',
						$itemChange.',previous:'.$this->_tabsModel->instock_item.
						',current:'.$this->_countInstock,true);	
		}

		$this->_tabsModel->instock_item = $this->_countInstock;
		$this->_tabsModel->save(false);
	}
	


}

?>