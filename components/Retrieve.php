<?php

class Retrieve
{
	private $_mainLogModel;
	private $_importModel;
	private $_importRoutineModel;
	private $_uploadDir;
	private $_downloadName;
	private $_newFileName;
	private $_filetime;
	private $_session;
	private $_notchanged = 0;

	
	function __construct($importId1){


		$this->init($importId1);
		
		$this->downloadSheet();

	}
	
	public function init($importId1)
	{

		$this->_uploadDir = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload';		
		
		if(!is_writable($this->_uploadDir))
			throw new CHttpException('500','Directory is not writable (Path:'.$this->_uploadDir.')');
		
		$this->_importRoutineModel = ImportRoutine::model()->findByPk($importId1);
	}
	
	public function downloadSheet()
	{
		$this->_importModel = $this->_importRoutineModel->getImportModel();
		
		$this->setNewFileName($this->_importRoutineModel);

		$this->checkZip($this->_importRoutineModel);
		
		$this->saveFile($this->_importRoutineModel);
		if(!$this->_notchanged)
			$this->unzipFile($this->_importRoutineModel);

		$this->saveToDB($this->_importRoutineModel);
		
	}
	
	function setNewFileName($importRoutineModel)
	{
		$this->_session = md5($importRoutineModel->id.$importRoutineModel->file_name.rand());
		$this->_newFileName = trim($importRoutineModel->id.'-'.$this->_session.'-'.$importRoutineModel->file_name);
	}
	
	function importLog($step ,$reason = '',$isFatal = false)
	{
		throw new CHttpException(500, $reason);
	}
	
	public function checkZip($importRoutineModel)
    {
	    $zipType = array(
	    	'none',
	    	'zip',
	    	'rar',
	    );
	    
	    $this->_downloadName = $importRoutineModel->file_name;
	    
	    
	    switch($importRoutineModel->unzip){
		    case 1:
		    	$info = pathinfo($importRoutineModel->file_name);
		    	break;
		    default:
		    	break;
	    }
	    
    }
    
    function getSheetNum($importRoutineModel)
    {
		if($importRoutineModel->id == $this->_importRoutineModel->id)    
			return 1;
		return 2;
    }
    
    function saveFile($importRoutineModel)
	{

		switch ($importRoutineModel->method_id){
			case 1://ftp
				$this->ftp($importRoutineModel);
				break;
	
			case 2://email
				$this->email($importRoutineModel);
				break;
	
	
			case 3://http
				$this->http($importRoutineModel);
				break;
			default:
		}
	}
	
	public function unzipFile($importRoutineModel)
	{
	
		$zipFile = trim($this->_uploadDir.DIRECTORY_SEPARATOR.'tempzipfile'.DIRECTORY_SEPARATOR. strtolower($importRoutineModel->zipped_file_name));

		switch($importRoutineModel->unzip){
			case 1:
		    	exec('unzip -LL -d upload/tempzipfile/ upload/' . $this->_newFileName,$result);
		    	break;
		    case 0:
		    	return;
		    	break;
		    default:
		    	$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Unzip file error.',true);
		    	break;
		}

		if(file_exists($zipFile) && copy($zipFile,$this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName))
			unlink($zipFile);
		else
			$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Filename did not exist in zip file.',true);
	}
	
	function saveToDB($importRoutineModel)
	{
		//make 8 row version
		$enclosure = empty($importRoutineModel->enclosure)?'':$importRoutineModel->enclosure;
		$delimiter = empty($importRoutineModel->delimiter)?',':$importRoutineModel->delimiter;
		
		if($delimiter == '\t')
			$delimiter = "\t";

		if($importRoutineModel->file_id == 1){
			if (($handle = fopen($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, "r")) !== FALSE) 
			    while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) 
					if($i++<8)
						$data[] = $row;
					else
						break;
		}else if($importRoutineModel->file_id == 3){
		
			Yii::import('application.vendors.PHPExcel',true);	

				
			
			$objPHPExcel = PHPExcel_IOFactory::load($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName);
			$objWorksheet = $objPHPExcel->getActiveSheet();
				
	
			foreach ($objWorksheet->getRowIterator() as $row_id=>$row){
				if($row_id<=8)
			    foreach ($row->getCellIterator() as $cell_id=>$cell)
			  		$row1[$cell_id] = trim($cell->getValue());
			  	else
			  		break;
			  	$data[] = $row1;
			}
			/*

			Yii::import('ext.excel.reader',true);	
			$row = array();
			
			$data = new Spreadsheet_Excel_Reader();
			var_dump(file_get_contents($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName));
			exit;
			exit;
			
			$data->read($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName);
			
			for ($i = 0; $i < $data->sheets[0]['numRows']; $i++) {
	
				
				
				if($i<8)
					for ($j = 0; $j < $data->sheets[0]['numCols']; $j++) 
						$row[$i][] = empty($data->sheets[0]['cells'][$i+1][$j+1])?' ':$data->sheets[0]['cells'][$i+1][$j+1];
				else
					break;
			}
		
*/

			
		}else{
			throw new CHttpException(400,'File type not supported');
		}
		$importRoutineModel->{'8rows'} = base64_encode(serialize($data));

		$this->_importModel->import_file_url = 'http://vims.axeo.net/upload/'.$this->_newFileName;
		$this->_importModel->save(false);
		$importRoutineModel->save(false);
	}
	
	function removeNewFile()
	{
		if(is_file($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName))
			unlink($this->_uploadDir.DIRECTORY_SEPARATOR.basename($this->_newFileName));
	}

	public function http($importRoutineModel)
	{
		
		
		$file = $importRoutineModel->http_url.'/'.$importRoutineModel->ftp_path.'/'.$this->_downloadName;

		$curl = curl_init($file);

		//don't fetch the actual page, you only want headers
		curl_setopt($curl, CURLOPT_NOBODY, true);
		
		//stop it from outputting stuff to stdout
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// attempt to retrieve the modification date
		curl_setopt($curl, CURLOPT_FILETIME, true);
		
		$result = curl_exec($curl);
		
		if ($result === false) {
		    die (curl_error($curl)); 
		}
		
		$timestamp = curl_getinfo($curl);
	
		$file = fopen ($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, 'w');
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $importRoutineModel->http_url.'/'.$importRoutineModel->ftp_path.'/'.$this->_downloadName);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $importRoutineModel->http_username.":".$importRoutineModel->http_password);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_FILE, $file);
		
		
		$content = curl_exec($ch);
		$info = curl_getinfo($ch);

		curl_close($ch);
		fclose($file);
		
		
		switch($info['http_code']){
				
			case 200://Success
				$this->setFileSize($importRoutineModel, $info['size_download']);
				return true;
				
			case 401://username and password incorrect
				$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Unauthorized (user:'.$importRoutineModel->http_username.',pass:'.$importRoutineModel->http_password.')',true);
				break;
				
			case 404://File name not found
				$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'File not found (Url:'.$importRoutineModel->http_url.'/'.$importRoutineModel->ftp_path.'/'.$this->_downloadName.')',true);
				break;
				
			default://Unknown error
				$this->_notchanged = 1;
				//$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Unknown Error(code:'.$info['http_code'].')');
				
		}

		
	}
	public function email($importRoutineModel)
	{

		$username = 'test+vims.axeo.net';
		$password = '?unbeataxeo1';
		
		
		$conn = @imap_open ("{localhost:993/imap/ssl/novalidate-cert}INBOX", $username, $password);
		if($conn == false)
			$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Email receivers are down,contact us',true);
			
		
		$mails   = imap_search($conn, 'SUBJECT "'.$importRoutineModel->email_subject.'" FROM "'.$importRoutineModel->email_sender.'"',SE_UID);
		
		if($mails != NULL){
			$uid = $mails[count($mails)-1];
			$attachs = $this->extract_attachments($conn, $uid);
			
			foreach($attachs as $attach)
				if($attach['is_attachment'] == true)
					if(file_put_contents($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, $attach['attachment'])){
						$this->setFileSize($importRoutineModel, strlen($attach['attachment']));
						return true;
					}
		}

		$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Mails not found',true);

			
		
	}
	
	public function ftp($importRoutineModel)
	{
		
		

		
		$curl = curl_init();
		$file = fopen ($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, 'w');

		curl_setopt($curl, CURLOPT_URL, $importRoutineModel->ftp_server.'/'.$importRoutineModel->ftp_path.'/'.$this->_downloadName);
		curl_setopt($curl, CURLOPT_USERPWD, $importRoutineModel->ftp_username.':'.$importRoutineModel->ftp_password);
		curl_setopt($curl, CURLOPT_FAILONERROR, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_FILE, $file);
	 
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		

		switch($info['http_code']){
		
			case 0://No FTP server found
				$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'No FTP service found (host:'.$importRoutineModel->ftp_server.')',true);
				break;
				
			case 226://Success
				$this->setFileSize($importRoutineModel, $info['size_download']);
				break;
				
			case 530://username and password incorrect
				$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Username or Password incorrect (user:'.$importRoutineModel->ftp_username.',pass:'.$importRoutineModel->ftp_password.')',true);
				break;
				
			case 550://File name not found
				$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'File not found (filename:'.$this->_downloadName.')',true);
				break;
				
			default://Unknown error
				$this->_notchanged = 1;
				//$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'Unknown Error(code:'.$info['http_code'].')');
				
		}
		curl_close($curl);
		fclose($file);
	}
	

	
    
    function extract_attachments($connection, $message_number) 
	{

		$attachments = array();
		$structure = imap_fetchstructure($connection, $message_number);
		
		if(isset($structure->parts) && count($structure->parts)) {
			for($i = 0; $i < count($structure->parts); $i++) {
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'attachment' => ''
				);
				if($structure->parts[$i]->ifdparameters) {
					foreach($structure->parts[$i]->dparameters as $object) {
						if(strtolower($object->attribute) == 'filename') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['filename'] = $object->value;
						}
					}
				}
				if($attachments[$i]['is_attachment']) {
					$attachments[$i]['attachment'] = imap_fetchbody($connection, $message_number, $i+1);
					if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					}
					elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
					}
				}
			}
		}
		return $attachments;
	}
	
	public function setFileSize($importRoutineModel, $filesize)
	{
		if($filesize <= 0){
			$this->removeNewFile();
			$this->importLog('download_sheet'.$this->getSheetNum($importRoutineModel),'File is empty',true);
		}
		
		$this->_mainLogModel->{'sheet'.$this->getSheetNum($importRoutineModel).'_file_size'} = $filesize;
		
	}
	
	
}

?>