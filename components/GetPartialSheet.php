<?php

class GetPartialSheet
{
	private $_routineModel;
	private $_logModel;
	private $_importModel;
	
	private $_downloadName;
	private $_uploadDir;
	private $_session;
	private $_filename;
	
	
	function __construct($import_id){
		set_time_limit(0);
		ini_set("memory_limit",-1);



		
		//Check if Import Routine Id correct
		$this->_routineModel = ImportRoutine::model()->findByPk($import_id);
		
		$this->_uploadDir = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload';
		$this->_filename = $this->_uploadDir.DIRECTORY_SEPARATOR.'temp2.file';
		//$this->_importModel = $this->_routineModel->getImportModel();
		

			
		$this->getDownloadFile();

		$file_id = 1;
		$enclosure = empty($this->_routineModel->enclosure)?'':$this->_routineModel->enclosure;
		$delimiter = empty($this->_routineModel->delimiter)?',':$this->_routineModel->delimiter;
		
		if($delimiter == '\t')
			$delimiter = "\t";
		Yii::import('application.vendors.PHPExcel',true);	
		$data = array();
		$i = 0;
		if($this->_routineModel->file_id == 1){
			if (($handle = fopen($this->_filename, "r")) !== FALSE) {
			    while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {


						
					if($i++<10)
						$data[] = $row;
					else
						break;
				}
			}
			
		}else if($this->_routineModel->file_id == 3){
			$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
			$cacheSettings = array( ' memoryCacheSize ' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

			$reader= PHPExcel_IOFactory::createReaderForFile($this->_filename);
			$reader->setReadDataOnly(true);
			$objPHPExcel= $reader->load($this->_filename);
					

			$objWorksheet = $objPHPExcel->getActiveSheet();
			foreach ($objWorksheet->getRowIterator() as $row_id=>$row){
			
				if($i++<10)
				    foreach ($row->getCellIterator() as $cell_id=>$cell)
						$data[$i-1][] = trim($cell->getValue());
				else
					break;
			    	
			}
			
		}else{
			throw new CHttpException(400,'File type not supported');
		}
		echo '<div style="clear:both;"></div>Last Retrieve Time:';
		echo $this->_routineModel->getImportModel()->last_import_time;
		echo '<table class="table table-bordered" class="span12">';

		foreach($data as $id=>$value){
			echo '<tr>';
			foreach($value as $id2=>$value2){

				echo '<td>';
				if($id==0){
					echo '<span :sheet_field='.$value2.' :sheet_num='.($id2+1).' class="draggable">';
					echo $value2;
					echo '<span>';	
				}else
					echo substr($value2,0,10);
				
				echo '</td>';
			}

			
			echo '<tr>';
		}
		echo '</table>';
		echo '<script>$(function(){$( ".draggable" ).draggable({ revert: "valid" });});</script>';
	}

	
	public function getDownloadFile()
	{
		
		if(is_writable($this->_uploadDir)){
			$ch = curl_init();
			$file = fopen ($this->_filename, 'w');
	
	
			curl_setopt($ch, CURLOPT_URL, $this->_routineModel->getImportModel()->import_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_FILE, $file);
			
			
			$content = curl_exec($ch);
			$info = curl_getinfo($ch);
	
			curl_close($ch);
			fclose($file);
			
		}		
	}

}

?>