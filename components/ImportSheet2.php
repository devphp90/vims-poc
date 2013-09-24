<?php 
/*
Get file from download server

import file into vSheet

*/
class ImportSheet2
{
	
	private $_routineModel;
	private $_logModel;
	private $_importModel;
	
	private $_isSheet2 = 0;
	private $sheet1id;
	private $_session;
	private $_warehouse;
	private $_newField;
	
	private $_downloadFile;
	private $_pureData = array();
	private $_dataIntegrityColumn = array();
	private $_column = array();
	private $_supItem = array();

	private $_boItem = array();
	private $_instockItem = array();
	private $_newItem = array();
	
	private $_match = array();
	private $_matchType;
	private $_countData;
	
	
	
	
	function __construct($id, $session)
	{
		$this->_session = $session;
		$this->_routineModel = ImportRoutine::model()->findByPk($id);

		$tabs = Tabs::model()->findByAttributes(array('import_routine_id_2'=>$id));
		
		if($tabs != null){
			$this->sheet1id = $tabs->import_routine_id;
			$this->_routineModel1 = ImportRoutine::model()->findByPk($this->sheet1id);
		}
		if($this->_routineModel == null)
			throw new CHttpException(400,'Premission denied');
		
		$this->setLogModel();
		
		$this->_importModel = $this->_routineModel->getImportModel();
		
		//$this->verifySession();
		
		$this->stepStatus('prepare',3);
		
		//$this->clearOldData($id);

		$this->getDownloadFile();
		
		$this->prepareUpdateField();
		$this->prepareMatch();
		$this->prepareUpdateData();
		
		$this->stepStatus('prepare',1);//Prepare pass!!
	}
	
	public function clearOldData($id)
	{
		$command = Yii::app()->db->createCommand();
		$command->delete('vims_import_vsheet', 'import_id', array(':id'=>$id));	
	}

	
	public function getDownloadFile()
	{
		$this->_downloadFile = @file_get_contents($this->_importModel->import_file_url);

		if(empty($this->_downloadFile))
			$this->updateLog('prepare','Download file error',true);
	}
	
	public function prepareUpdateField()
	{
		
		$this->_newField = array(
			'mfg_sku'=>'new_mfg_sku',
			'upc'=>'new_upc',
			'mfg_name'=>'new_mfg_name',
			'mfg_part_name'=>'new_mfg_part_name',
			'sup_sku'=>'new_sup_sku',
			'sup_sku_name'=>'new_sup_sku_name',
			'sup_description'=>'new_sup_description',
		);
		
		$this->_warehouse = array(
			'1'=>'ware_1',
			'2'=>'ware_2',
			'3'=>'ware_3',
			'4'=>'ware_4',
			'5'=>'ware_5',
			'6'=>'ware_6',
		);
	}
	
	public function prepareUpdateData()
	{

		switch ($this->_routineModel->file_id){
			case 1://csv
				$this->convertCSV();
				break;
			
			case 2://txt
				break;
			
			case 3://xls
				$this->convertXLS();
				break;	
				
			default:
				$this->updateLog('prepare','File type error(file_id:'.$this->_routineModel->file_id.')',true);
		}


		return;
		if(!is_array($this->_pureData) || empty($this->_pureData))
			$this->updateLog('prepare','Empty file',true);

		$this->filterEmptyRows();
		
		$this->_countData = count($this->_pureData);
		
		$this->_logModel->item_number = $this->_countData;
		$this->_logModel->save();
		
	}
	
	public function convertCSV()
	{
		
		
		
			if($this->_routineModel1->default_price>0){
				$vsheets = ImportVsheet::model()->findAllByAttributes(array(
					'import_id'=>$this->sheet1id,
				));
				foreach($vsheets as $id=>$value){
					$value->sheet_type = 1;
					$value->price = $this->_routineModel1->default_price;
					$value->save();
				}
			}else{
				$delimiter = empty($this->_routineModel->delimiter)?',':$this->_routineModel->delimiter;
				$enclosure = empty($this->_routineModel->enclosure)?'':$this->_routineModel->enclosure;
				$data = str_getcsv($this->_downloadFile, "\n"); 
				//$data = array_map('trim',explode("<br />", nl2br($this->_downloadFile)));
				if($delimiter == '\t')
					$delimiter = "\t";
				foreach($data as $id=>&$row){ 
					
		
					if($this->_routineModel->match_startby-1 > $id)
						continue;
		
					$row = array_map('trim',str_getcsv($row, $delimiter, $enclosure));
		
					if(empty($this->column_number))
						$this->column_number = count($row);
		
					$vsheet = ImportVsheet::model()->findByAttributes(array(
							'import_id'=>$this->sheet1id,
							'mfg_sku'=>$row[$this->_newField['mfg_sku']],
						));
						
					if($vsheet != null){
		
		
						$vsheet->sheet_type = 1;
						$vsheet->price = $row[$this->_match['price']];
						$vsheet->save();
						
					}else
						unset($this->_pureData[$id]);
						
				}
			}

		$this->_pureData = array_values($this->_pureData);
		unset($this->_downloadFile);
		unset($data);

	}
	
	public function convertXLS()
	{
		if($this->_routineModel1->default_price>0){
			$vsheets = ImportVsheet::model()->findAllByAttributes(array(
				'import_id'=>$this->sheet1id,
			));
			foreach($vsheets as $id=>$value){
				$value->sheet_type = 1;
				$value->price = $this->_routineModel1->default_price;
				$value->save();
			}
		}else{
		
		
			Yii::import('application.vendors.PHPExcel',true);	


			$dir = Yii::getPathOfAlias('ext.phpexcelreader');
			if(!file_put_contents($dir.'/test.xlsx', $this->_downloadFile))
				$this->updateLog('prepare','Local Temporary not writable',true);
				
			
			$objPHPExcel = PHPExcel_IOFactory::load($dir.'/test.xlsx');
			$objWorksheet = $objPHPExcel->getActiveSheet();
				
	
			foreach ($objWorksheet->getRowIterator() as $row_id=>$row){
			
				if($this->_routineModel->match_startby > $row_id)
					continue;
					
				$row1 = array();
	
			    foreach ($row->getCellIterator() as $cell_id=>$cell)
			  		$row1[$cell_id] = trim($cell->getValue());
	
			  	if(empty($this->column_number))
					$this->column_number = count($row1);
					
				$vsheet = ImportVsheet::model()->findByAttributes(array(
						'import_id'=>$this->sheet1id,
						'mfg_sku'=>$row1[$this->_newField['mfg_sku']],
					));
					
					
			  	if($vsheet != null){
	
	
					$vsheet->sheet_type = 1;
					$vsheet->price = $row1[$this->_match['price']];
					$vsheet->save();
					
				}else
					unset($this->_pureData[$id]);

			  		
			}

		}
		


	}
	
	public function prepareMatch()
	{
			
			
		$this->matchType = $this->_routineModel->match_column;
		$this->_match = array(
			'match1'=>$this->getMatchValue($this->_routineModel->sup_match_column),
			'match2'=>$this->getMatchValue($this->_routineModel->sup_match_column_1),
			'match3'=>$this->getMatchValue($this->_routineModel->sup_match_column_2),
			'price'=>$this->getMatchValue($this->_routineModel->price),
			'map'=>$this->getMatchValue($this->_routineModel->min_adv_price),
		);

		foreach($this->_warehouse as $target => &$field){
			$field = $this->getMatchValue($this->_routineModel->$field);
			if($field === NULL)
				unset($this->_warehouse[$target]);
		}
		
		$this->matchType = $this->_routineModel->new_map_by;
		foreach($this->_newField as $target => &$field){
			$field = $this->getMatchValue($this->_routineModel->$field);
			if($field === NULL)
				unset($this->_newField[$target]);
		}
	}
	
	public function getMatchValue($field)
	{
		if(empty($field))
			return NULL;
		else if(!$this->matchType)	//Match by #
			return $field-1;
		else	//Match by field name
			return array_search(strtolower($field),$this->_column);
		
	}
	
	public function filterEmptyRows()
	{
		
		foreach($this->_pureData as $id=>$row)
			if(empty($row['sup_vsku']))
				unset($this->_pureData[$id]);
	}
	
	public function setLogModel()
	{
		if(!isset($this->_routineModel->log)){
			$this->_logModel = new Logs;
			$this->_logModel->import_id = $this->_routineModel->id;
			//$this->_logModel->save();

			throw new CHttpException(400,'Can\'t find update log');
			
		}else
			$this->_logModel = $this->_routineModel->log;

	}
	
	public function updateLog($step,$reason = '',$is_fatal = false)
	{
		$this->_logModel->{$step.'_reason'} .= $reason.'<br/>';
		$this->_logModel->save();
		
		if($is_fatal == true){
			$this->_logModel->{$step.'_status'} = 0;
			$this->_logModel->save();
			throw new CHttpException(400,$step .' - '. $reason);
		}
	}
	
	public function stepStatus($step,$start = 3)
	{
		$this->_logModel->{$step.'_status'} = $start;
		$this->_logModel->save();
	}
}

?>