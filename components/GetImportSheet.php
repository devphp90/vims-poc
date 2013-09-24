<?php

class GetImportSheet
{
	private $_routineModel;
	private $_logModel;
	private $_importModel;
	
	private $_downloadName;
	private $_newFileName;
	private $_uploadDir;
	private $_session;
	
	
	function __construct($import_id){




		
		//Check if Import Routine Id correct
		$this->_routineModel = ImportRoutine::model()->findByPk($import_id);
		
		$this->_uploadDir = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload';
		$this->_newFileName = 'temp.file';
		//$this->_importModel = $this->_routineModel->getImportModel();
		

			
			
		
		$this->checkZip();
		
		$this->saveFile();

		$this->unzipFile();
		

		$filename = $this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName;

		

		$file_id = 1;
		$enclosure = empty($this->_routineModel->enclosure)?'':$this->_routineModel->enclosure;
		$delimiter = empty($this->_routineModel->delimiter)?',':$this->_routineModel->delimiter;
		
		if($delimiter == '\t')
			$delimiter = "\t";
		Yii::import('application.vendors.PHPExcel',true);	
		if($this->_routineModel->file_id == 1){
			if (($handle = fopen($filename, "r")) !== FALSE) {
			    $column = fgetcsv($handle, 1000, $delimiter, $enclosure);
			}
			
		}else if($this->_routineModel->file_id == 3){
					
			$objPHPExcel = PHPExcel_IOFactory::load($filename);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			foreach ($objWorksheet->getRowIterator() as $row_id=>$row){
			
	
			    foreach ($row->getCellIterator() as $cell_id=>$cell)
			  		$column[$cell_id] = trim($cell->getValue());
			  	break;
			}
			
		}else{
			throw new CHttpException(400,'File type not supported');
		}
//		$column = array();

		$this->_routineModel->fetch_column = base64_encode(serialize($column));
		$this->_routineModel->save();
	
	
		//$this->unzipFile();
		
		
	}
	
	public function getColumn()
	{
		return base64_decode($this->_routineModel->fetch_column);
		
	}
	
	
	public function unzipFile(){
		$zipFile = trim($this->_uploadDir.DIRECTORY_SEPARATOR.'tempzipfile'.DIRECTORY_SEPARATOR.strtolower($this->_routineModel->file_name));
		switch($this->_routineModel->unzip){
			case 1:
				
		    	exec('unzip -LL -d upload/tempzipfile/ upload/' . $this->_newFileName,$result);
		    	break;
		    case 0:
		    	return;
		    	break;
		    default:
		    	$this->importLog('Downloading','Unzip file Error',true);
		    	break;
		}

		if(file_exists($zipFile) && copy($zipFile,$this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName))
			unlink($zipFile);
		else
			$this->importLog('Downloading','File name not in zip file',true);
	}
	
    public function checkZip()
    {
	    if(empty($this->_routineModel->file_name))
			$this->importLog('Downloading','Filename is empty',true);
			
	    $zipType = array(
	    	'none',
	    	'zip',
	    	'rar',
	    );
	    $this->_downloadName = $this->_routineModel->file_name;
	    
	    switch($this->_routineModel->unzip){
		    case 1:
		    	$info = pathinfo($this->_routineModel->file_name);
		    	$this->_downloadName = $importRoutineModel->zipped_file_name;
		    	break;
		    default:
		    	break;
	    }
	    
    }

	function importLog($step,$reason = '',$is_fatal = false)
	{
		/*
$this->_logModel->import_reason .= $step.(!empty($reason)?' - '.$reason:'').'<br/>';

		if($is_fatal == true){
		
			$this->_logModel->import_status = 0;
			$this->_logModel->save();
			throw new CHttpException(400,$step .' - '. $reason);
			
		}else
			$this->_logModel->save();
*/
	}
	function saveFile()
	{
		//echo $this->_routineModel->file_name;
		//exit;
		switch ($this->_routineModel->method_id){
			case 1://ftp
				$result = $this->ftp();
				break;
	
	
			case 2://email
				$result = $this->email();
				break;
	
	
			case 3://http
				$result = $this->http();
				break;
		}
	}
	
	public function http()
	{


		$ch = curl_init();
		$file = fopen ($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, 'w');


		curl_setopt($ch, CURLOPT_URL, $this->_routineModel->http_url.'/'.$this->_downloadName);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $this->_routineModel->http_username.":".$this->_routineModel->http_password);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_FILE, $file);
		
		
		$content = curl_exec($ch);
		$info = curl_getinfo($ch);

		curl_close($ch);
		fclose($file);
		
		
		switch($info['http_code']){
				
			case 200://Success
				$this->setFileSize($info['size_download']);
				return true;
				
			case 401://username and password incorrect
				$this->importLog('Downloading','Unauthorized (user:'.$this->_routineModel->http_username.',pass:'.$this->_routineModel->http_password.')',true);
				break;
				
			case 404://File name not found
				$this->importLog('Downloading','File not found (Url:'.$this->_routineModel->http_url.'/'.$this->_downloadName.')',true);
				break;
				
			default://Unknown error
				$this->importLog('Downloading','Unknown Error(code:'.$info['http_code'].')');
				
		}

		
		
	}
	public function email()
	{

		$username = 'test+vims.axeo.net';
		$password = '?unbeataxeo1';
		
		
		$conn = @imap_open ("{localhost:993/imap/ssl/novalidate-cert}INBOX", $username, $password);
		if($conn == false)
			$this->importLog('Downloading','Email receivers are down,contact us',true);
			
		
		$mails   = imap_search($conn, 'SUBJECT "'.$this->_routineModel->email_subject.'" FROM "'.$this->_routineModel->email_sender.'"',SE_UID);
		
		if($mails != NULL){
			$uid = $mails[count($mails)-1];
			$attachs = $this->extract_attachments($conn, $uid);
			
			foreach($attachs as $attach)
				if($attach['is_attachment'] == true)
					if(file_put_contents($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, $attach['attachment'])){
						$this->setFileSize(strlen($attach['attachment']));
						return true;
					}
		}

		$this->importLog('Downloading','Mails not found',true);

			
		
	}
	
	
	
	
	
	public function ftp()
	{

		$curl = curl_init();
		$file = fopen ($this->_uploadDir.DIRECTORY_SEPARATOR.$this->_newFileName, 'w');
		

		curl_setopt($curl, CURLOPT_URL, $this->_routineModel->ftp_server.'/'.$this->_downloadName);
		curl_setopt($curl, CURLOPT_USERPWD, $this->_routineModel->ftp_username.':'.$this->_routineModel->ftp_password);
		curl_setopt($curl, CURLOPT_FAILONERROR, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_FILE, $file);
	 
	 
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		

		switch($info['http_code']){
		
			case 0://No FTP server found
				$this->importLog('Downloading','No FTP service found (host:'.$this->_routineModel->ftp_server.')',true);
				break;
				
			case 226://Success
				$this->setFileSize($info['size_download']);
				return true;
				
			case 530://username and password incorrect
				$this->importLog('Downloading','Username or Password incorrect (user:'.$this->_routineModel->ftp_username.',pass:'.$this->_routineModel->ftp_password.')',true);
				break;
				
			case 550://File name not found
				$this->importLog('Downloading','File not found (filename:'.$this->_downloadName.')',true);
				break;
				
			default://Unknown error
				$this->importLog('Downloading','Unknown Error(code:'.$info['http_code'].')');
				
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
	
	public function setFileSize($filesize)
	{
		
	}
}

?>