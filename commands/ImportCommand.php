<?php
 
class ImportCommand extends CConsoleCommand {
	
	private $supImportInfo;
	//private $importLog;
	private $timestamp;
	
	public function run($args) {
		// get supplier id - this will be supplier in args by the caller
		if (!isset($args[0]) || !isset($args[1])) {
			echo 'you must provide a supplier id & info type for this service';
			exit(0);
		}
		$supId = $args[0];
		$infoType = $args[1];
		echo "loading supplier import info\n";
		$this->loadSupplierInfo($supId, $infoType);

		if (empty($this->supImportInfo)) {
			echo "no mapping found for supplier $supId $infoType file";
			exit(0);
		}
		//if ($this->supImportInfo) {
			//write processing to import log
		$importLog = new ImportLog;
		$importLog->sup_id = $this->supImportInfo->sup_id;
		$importLog->info_type = $this->supImportInfo->info_type;
		$timestamp = time(); //record timestamp to match database and filename tag
		$date = date('Y-m-d H:i:s', $timestamp);
		$importLog->imp_date = $date;
		$importLog->imp_status = 'IMPORTING';
		$importLog->stts_date = date('Y-m-d H:i:s');
		$importLog->imp_try = 0;
		$importLog->save();
		
		// check what type of communication is needed
		echo "preparing to download $infoType sheet from " . $this->supImportInfo->supplier->sup_name . "\n";
		switch ($this->supImportInfo->conn_type) {
			case 'FTP':
				// process ftp
				$this->ftpImport();
				break;
			case 'HTTP':
				// process http
				echo 'this one is http';
				break;
			case 'EMAIL':
				// process email
				echo 'this is email';
				break;
			default:
				echo "unrecognized connection type - check database";
		}
		// rename and move file from raw to current
		$fileTag = $this->supImportInfo->sup_id . '.' . $this->supImportInfo->info_type . '.';
		// first check if in current there are files from this supplier and move to prev
		$older = glob(Yii::app()->params->currentDir.$fileTag.'*');
		foreach ($older as $old) {
			//echo $old;
			rename($old, Yii::app()->params->archiveDir.basename($old));
		}
		// now rename and move to current
		$newFileTag = $fileTag.date('Y.m.d.H.i', $timestamp);
		$newFile = $newFileTag.'.'.$this->supImportInfo->file_type;
		copy(Yii::app()->params->rawDir.$this->supImportInfo->file_name, Yii::app()->params->currentDir.$newFile);
		
		// now convert file into database import format based on mapping.
		$this->createDBImport($newFileTag, $newFile, $importLog->imp_id);
		
		// update import table and create entry in statistics
		$importLog->imp_status = 'READY_TO_LOAD';
		$importLog->stts_date = date('Y-m-d H:i:s');
		$result = $importLog->update(array('imp_status','stts_date'));
		//var_dump($importLog);
		Yii::app()->end();
	}
	
	private function ftpImport() {
		if(!function_exists('ftp_connect')) {
    	echo "PHP FTP extension must be installed and enabled!";
    	exit(0);
    }
		$ftp = Yii::app()->ftp;
		$ftp->username = $this->supImportInfo->username;
		$ftp->password = $this->supImportInfo->pwd;
		$ftp->host = $this->supImportInfo->uri;
		//echo $ftp->host;

		$ftp->setActive(true);
		if (!$ftp->getActive()) {
			echo "connection to ftp failed";
			// report to database, add retry count
			exit(0);
		}
		echo "connected to ftp site\n";
		//download file
		// determine ftp mode
		switch ($this->supImportInfo->file_type) {
			case 'TXT':
			case 'XML':
			case 'CSV':
			case 'JSON':
				$mode = FTP_ASCII;
				break;
			default:
				// this covers both ZIP and XLS XLSX MDB etc.
				$mode = FTP_BINARY;
		}
		//set source and destination
		if ($this->supImportInfo->zipped) {
			$filename = $this->supImportInfo->zip_fname;
			// override mode since ZIP is a BINARY file regardless of the contents
			$mode = FTP_BINARY;
		}
		else {
			$filename = $this->supImportInfo->file_name;
		}
		//$dest = Yii::app()->params->rawDir.$this->supImportInfo->sup_id.'.'.$this->supImportInfo->info_type.'.'.$filename;
		$dest = Yii::app()->params->rawDir.$filename;
		echo "downloading $filename to $dest ...please wait\n";
		$result = $ftp->get($dest, $filename, $mode);
		echo "download complete $result\n";
		// close generating error - TO DO:fix
		//$ftp->setActive(false);
		// extract if file is zip
		if ($this->supImportInfo->zipped) { //unzip file to readable format
			//extract data file
			$zip = Yii::app()->zip;
			echo "download is zip file...extracting $dest\n";
			//our zip file is now the source (first parameter of the function) for extraction
			$zip->extractZip($dest,  Yii::app()->params->rawDir);
			echo "data file extracted\n";
		}
	}

	private function createDBImport($filename, $input, $impId) {
		$output = $filename.'.TXT';
		if (($outh = fopen(Yii::app()->params->dbInputDir.$output, "w")) == FALSE) { 
			echo "unable to create output file\n";
			exit(0);
		}
		// here we will add switch for type file - currently dealing with delimited text file
		echo "...processing $input...\n";
		$rowNum = 0;
		$skipCount = 0;
		if (($handle = fopen(Yii::app()->params->currentDir.$input, "r")) !== FALSE) {
			// first read through skip rows
			while ($this->supImportInfo->skip_rows>$rowNum && (($data = fgetcsv($handle, 1000, $this->supImportInfo->dlmtr)) !== FALSE)) {
				$rowNum++;
				//print_r($data);
				if ($this->supImportInfo->header == $rowNum) {
					$header = $data;
				}
			}
			// header should be used to compare column placement - currently not used
			$rowNum = 0; //reset after skip rows
			$delim = Yii::app()->params->vimsDelimeter;
			// to do - handle different files types, this only works well for TXT and CSV (db CSV should have delimiter defined)
			while (($data = fgetcsv($handle, 2000, $this->supImportInfo->dlmtr)) !== FALSE) {
				$rowNum++;
				//print_r($data);
				//if ($rowNum>3728) print_r($data) . "\n";
				$row = $rowNum . $delim 
						 . $this->extract($data,$this->supImportInfo->sku) . $delim
						 . $this->extract($data,$this->supImportInfo->mpn) . $delim
						 . $this->extract($data,$this->supImportInfo->mfc_name) . $delim
						 . $this->extract($data,$this->supImportInfo->upc) . $delim
						 . $this->extract($data,$this->supImportInfo->item_name) . $delim
						 . '0' . $delim //here sits an array of location ids which is relevant to multi supplier inventory - to do
						 . $this->extract($data,$this->supImportInfo->qntty) . $delim
						 . $this->extract($data,$this->supImportInfo->price) . $delim
						 . preg_replace("/\r|\n/",' ',trim(implode($this->supImportInfo->dlmtr, $data))) . "\n"; //save full row as the last entry in the row
						 // to do - handle different file types that have no delimiter, maybe use standard delim for row otherwise Excel files will have none
				fwrite($outh, $row);
			}
			
			fclose($handle);
		}
		else {
			echo "failed to open file $input\n";
			exit(0);
		}
		fclose ($outh);
		// write stats with rowNum into import stats
		
		$importStats = new ImportStats();
		$importStats->imp_id = $impId;
		$importStats->sup_id = $this->supImportInfo->sup_id;
		$importStats->crtn_date = date('Y-m-d H:i:s');
		$importStats->file_name = $output;
		$importStats->item_count = $rowNum;
		$importStats->save();
		
		echo "...file ready for database\n";
	}
	
	private function extract($data, $idx) {
		if (!isset($idx)) {
			return '';
		}
		return preg_replace("/\r|\n/",' ',trim($data[$idx]));
	}
	
	private function loadSupplierInfo($supId, $infoType) {
		$this->supImportInfo = SupColMap::model()->find(array(
			'condition'=>'sup_id=:sup_id AND info_type=:info_type',
			'params'=>array(':sup_id'=>$supId, ':info_type'=>$infoType),
		));
	}
	
	public function actionBySupplier($supplierId, $retry=null) {
		// Load required
		$this->loadRequired();
	
		// Checking requirements
		$this->echoMessage('Checking Requirements');
		if(!$this->checkRequirements()) {
			return;
		}
		
		// Check path
		if(!$this->checkFilePath()) {
			return;
		}
		
		// Set retries
		if($retry !== null) {
			self::$attempts = $retry;
		}
		
		// Start the process
		$this->echoMessage('Process Started');
		
		// Get a supplier
		$this->echoMessage('Getting supplier');
		$supplier = $this->getSupplier($supplierId);
		
		// Make sure we have one
		if(!$supplier) {
			$this->echoMessage('No supplier matched. Aborting.');
			return;
		}
		
		// Starting process
		$this->echoMessage(sprintf("Started process for '%s' ID: %s", $supplier->name, $supplier->id));
		
		// Mark supplier is_started
		$supplier->is_started = 1;
		$supplier->update();
		
		// Connect to the supplier link based on the connection_type and get the file/contents
		// if they exists
		switch($supplier->connection_type) {
			case 'HTTP':
				$contents = $this->getHttpFile($supplier);
			break;
			
			case 'FTP':
				$contents = $this->getFTPFile($supplier);
			break;
			
			case 'EMAIL':
				$contents = $this->getEmailFile($supplier);
			break;
			
			
			default:
				$this->echoMessage('Connection type is not defined for this supplier!');
				$this->finishAndMark($supplier);
    			return;	
			break;
		}
		
		// If we have false then exit
		if($contents === false) {
			$this->echoMessage('No content was returned!');
			$this->finishAndMark($supplier);
    		return;
		}
		
		$this->echoMessage('Attempting to save file');
		
		// Save file
		if(!$this->saveFile($supplier, $contents)) {
			$this->echoMessage('Could not save file');
			$this->finishAndMark($supplier);
    		return;
		}
		
		$this->echoMessage('File saved!');
		
		// Mark last run
		$this->finishAndMark($supplier);
    }
    
    /**
     * Reset started suppliers
     *
     */
    public function actionResetStarted() {
    	$this->loadRequired();
    	Supplier::model()->updateAll(array('is_started' => 0));
    }
    
    protected function loadRequired() {
    	// Load required
		Yii::import('application.models.*');
    }
    
    /** 
     * Get supplier latest file name
     * @return string
     */
    protected function getFileName($supplier) {
    	return sprintf('latest.%s', strtolower($supplier->file_type));
    }
    
    /**
     * Rename old supplier file name
     * @return boolean
     */
    protected function renameOldFile($supplier) {
    	// Check if the files exists
		$file_exists = SUPPLIERS_DIR_PATH . '/' . $supplier->id . '/' . $this->getFileName($supplier);
		
		if(file_exists($file_exists)) {
			$new_file_name = sprintf("%s/%s/OLD_%s.%s", SUPPLIERS_DIR_PATH, $supplier->id, date('m_d_y_H.i', filemtime($file_exists)), strtolower($supplier->file_type));
			$this->echoMessage(sprintf("Renaming file '%s' to '%s'", $file_exists, $new_file_name));
			// Rename the file
			rename($file_exists, $new_file_name);
		}
		
		return true;
    }
    
    /**
     * Return a supplier saved file full path
     * @return string
     */
    protected function getLatestFullPath($supplier) {
    	return SUPPLIERS_DIR_PATH . '/' . $supplier->id . '/' . $this->getFileName($supplier);
    }
    
    /**
     * Saves contents to a new file
     * @return void
     */
    protected function saveFile($supplier, $contents) {
    	// Once we have the contents save it to the directory
		$supplier_filename = SUPPLIERS_DIR_PATH . '/' . $supplier->id . '/' . $this->getFileName($supplier);
		
		// Make sure dir exists
		if(!is_dir(SUPPLIERS_DIR_PATH . '/' . $supplier->id)) {
			if(!@mkdir(SUPPLIERS_DIR_PATH . '/' . $supplier->id, 0777)) {
				$this->errorMessage('Could not create supplier files folder.');
    			return false;
			}
		}
		
		// rename previous file
		$this->renameOldFile($supplier);
		
		$this->echoMessage(sprintf("Saving file to '%s'", $supplier_filename));
		
		// Save new file
		return file_put_contents($supplier_filename, $contents);
    }
    
    /**
     * make sure suppliers path exists
     */
    protected function checkFilePath() {
    	if(!is_dir(SUPPLIERS_DIR_PATH)) {
    		if(!mkdir(SUPPLIERS_DIR_PATH)) {
    			$this->errorMessage(sprintf("The suppliers files path '%s' is not present.", SUPPLIERS_DIR_PATH));
    			return false;
    		}
    	}
    	
    	return true;
    }
    
    /**
     * Return a file that is attached to an email by logging into the email
     * @param object $supplier
     * @return string
     */
    protected function getEmailFile($supplier) {
    	Yii::import('application.extensions.Imap.*');
    	$contents = null;
    	
    	// Make sure path exists
    	if(!is_dir($this->getFilesPath())) {
    		if(!@mkdir($this->getFilesPath())) {
    			$this->errorMessage('Could not create ftp temp local directory.');
    			return false;
    		}
    	}
    	
    	// Make sure all info is provided
    	if(!$supplier->email_string) {
    		$this->errorMessage('Email connection string is missing.');
    		return false;
    	}
    	
    	if(!$supplier->username || !$supplier->password) {
    		$this->errorMessage('Email username/password missing.');
    		return false;
    	}
    	
    	// Load imap
    	$imap = new ImapWrapper($supplier->email_string, $supplier->username, $supplier->password);
    	$emails = $imap->email()->searchMail(array('FROM' => $supplier->email_sender, 'SUBJECT' => $supplier->email_subject));
    	
    	// Make sure we have emails matched
    	if(!count($emails)) {
    		$this->errorMessage('No Emails matched!');
    		return false;
    	}
    	
    	// Flag
    	$found = false;
    	$attachement_file = null;
    	$email_matched = null;
    	
    	// Loop the emails and see if we can find an attachment with the required name
    	foreach($emails as $email) {
    		$attachments = $email->getAllAttachments(true);
    		if(!count($attachments)) {
    			continue;
    		}
    		
    		foreach($attachments as $attachment) {
    			// Does this attachment matches our file name?
    			if(in_array($supplier->file_name, array($attachment['filename'], $attachment['name']))) {
    				// It is we have the file
    				$attachement_file = $email->getAttachmentByName($attachment['name']);
    				$email_matched = $email;
    				$found = true;
    				break 2;
    			}
    		}
    	}
    	
    	// Did we match the attachment?
    	if(!$found || !isset($attachement_file[0]['attachment']) || !$attachement_file[0]['attachment']) {
    		$this->errorMessage('No attachments were found in the email.');
    		return false;
    	}
    	
    	// Find file and save in temp dir
		$filepath = $this->getFilesPath() . '/' . $supplier->id . '_temp.' . strtolower($supplier->file_type);
		
		// Make sure we create the file first
		if(file_exists($filepath)) {
			// Delete it then create it
			unlink($filepath);
			file_put_contents($filepath, '');
		} else {
			// Create it
			file_put_contents($filepath, '');
		}
		
		// Check time first
		if(file_exists($this->getLatestFullPath($supplier))) {
			// We have the latest
			$current_time = filemtime($this->getLatestFullPath($supplier));
			$remote_time = $email->getTimeInt();
			if($remote_time) {
				// Stop if the remote time is not newer then the current time
				if($remote_time && $remote_time <= $current_time) {
					$this->echoMessage('File present but is not newer then the current one. Aborting.');
					return false;
				}
			}
		}
    	
    	$this->echoMessage('File downloaded');
    		
    	return $attachement_file[0]['attachment'];
    }
    
    /**
     * Get file contents from ftp
     * @param object @supplier
     * @return string
     */
    protected function getFTPFile($supplier) {
    	Yii::import('application.extensions.FTPClient');
    	$contents = null;
    	
    	// Make sure path exists
    	if(!is_dir($this->getFilesPath())) {
    		if(!@mkdir($this->getFilesPath())) {
    			$this->errorMessage('Could not create ftp temp local directory.');
    			return false;
    		}
    	}
    	
    	// Try
    	try {
    		// BUG: We need to parse the url so only the host is passed to the ftp
    		// client, otherwise there is an error, first check if it has ftp://, http://, ftps://, https://
    		preg_match('~(ftp://|ftps://|http://|https://)~i', $supplier->uri, $matches);
    		if(count($matches)) {
    			$url = parse_url($supplier->uri);
    			$host = $url['host'];
    		} else {
    			$host = trim($supplier->uri);
    		}
    		
    		
    		$username = trim($supplier->username);
    		$password = trim($supplier->password);
    		
    		// Loging in
    		$this->echoMessage(sprintf("Loging to '%s' with U: '%s', P: '%s'", $host, $username, $password));
    		
    		$ftp = new FTPClient($host);
    		// Login
    		try {
    			$ftp->connect($username, $password);
    		} catch(FTPException $exception) {
    			// Faild to login then we try again if we need to
    			if(self::$attempts > self::MAX_ATTEMPTS) {
    				// Quit
    				$this->errorMessage('Unable to connect to remote source, All retries failed. Aborting.');
    				$this->finishAndMark($supplier);
    				exit;
    			} else {
    				// Tell the user that there was a problem and we will retry in X seconds
    				$this->retryMark($supplier);
    				exit;
    			}
    		}
    		
    		
    		// Find file and save in temp dir
    		$filepath = $this->getFilesPath() . '/' . $supplier->id . '_temp.' . strtolower($supplier->file_type);
    		
    		// Make sure we create the file first
    		if(file_exists($filepath)) {
    			// Delete it then create it
    			unlink($filepath);
    			file_put_contents($filepath, '');
    		} else {
    			// Create it
    			file_put_contents($filepath, '');
    		}
    		
    		$downloadfile = trim($supplier->file_name);
    		
    		// Make sure remote file exists
    		if(!$ftp->fileExists($downloadfile)) {
    			$this->errorMessage('Remote file does not exists.');
    			return false;
    		}
    		
    		// Check time first
    		if(file_exists($this->getLatestFullPath($supplier))) {
    			// We have the latest
    			$current_time = filemtime($this->getLatestFullPath($supplier));
    			$remote_time = $ftp->getRemoteFileTime($downloadfile);
    			
    			// Stop if the remote time is not newer then the current time
    			if($remote_time <= $current_time) {
    				$this->echoMessage('File present but is not newer then the current one. Aborting.');
    				return false;
    			}
    		}
    		
    		// Logged in attempting to download
    		$this->echoMessage(sprintf("Logged in! Attempting to download: '%s'", $downloadfile));
    		
    		$ftp->downloadFile($filepath, $downloadfile, FTPClient::MODE_ASCII, true);
    		if(!file_exists($filepath)) {
    			$this->errorMessage('File was not saved.');
    			return false;
    		}
    		
    		$this->echoMessage('File downloaded');
    		
    		// Grab contents
    		$contents = file_get_contents($filepath);
    	} catch(Exception $e) {
    		$this->echoMessage($e->getMessage());
    		return false;
    	}
    	
    	return $contents;
    }
    
    /**
     * Get file contents by curl
     * @param object @supplier
     * @return string
     */
    protected function getHttpFile($supplier) {
    	$contents = null;
    	
    	// Make sure uri exists
    	if(!$supplier->uri) {
    		$this->finishAndMark($supplier);
    		return false;	
    	}
    	
    	// INIT CURL
		$ch = curl_init();
		
		# Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		# not to print out the results of its query.
		# Instead, it will return the results as a string return value
		# from curl_exec() instead of the usual true/false.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
    	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    	curl_setopt($ch, CURLOPT_MAXREDIRS, self::MAX_ATTEMPTS);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		
    	// Do we have username and pass?
    	if($supplier->username && $supplier->password) {
    		// Login to the site and grab the data
    		curl_setopt($ch, CURLOPT_URL, $supplier->uri);
			curl_setopt($ch, CURLOPT_POST, 1);
			// IMITATE CLASSIC BROWSER'S BEHAVIOUR : HANDLE COOKIES
			curl_setopt($ch, CURLOPT_COOKIEJAR, $supplier->id . '_cookie.txt');
			
			// EXECUTE 1st REQUEST (FORM LOGIN)
			$store = curl_exec($ch);
    	}
    	
    	// Find file and save in temp dir
		$filepath = $this->getFilesPath() . '/' . $supplier->id . '_temp.' . strtolower($supplier->file_type);
		
		// Make sure we create the file first
		if(file_exists($filepath)) {
			// Delete it then create it
			unlink($filepath);
			file_put_contents($filepath, '');
		} else {
			// Create it
			file_put_contents($filepath, '');
		}
		
		$downloadfile = trim($supplier->uri);
		
		// Make sure remote file exists
		if(!$this->httpFileExists($downloadfile)) {
			$this->errorMessage('Remote file does not exists.');
			return false;
		}
		
		// Check time first
		if(file_exists($this->getLatestFullPath($supplier))) {
			// We have the latest
			$current_time = filemtime($this->getLatestFullPath($supplier));
			$remote_info = $this->getHTTPInfo($downloadfile);
			if(isset($remote_info['filetime']) && $remote_info['filetime']) {
				$remote_time = $remote_info['filetime'];
				// Stop if the remote time is not newer then the current time
				if($remote_time && $remote_time <= $current_time) {
					$this->echoMessage('File present but is not newer then the current one. Aborting.');
					return false;
				}
			}
		}
		
		// Logged in attempting to download
		$this->echoMessage(sprintf("Logged in! Attempting to download: '%s'", $downloadfile));
		
		// SET FILE TO DOWNLOAD
		curl_setopt($ch, CURLOPT_URL, $supplier->uri);
		
		// EXECUTE 2nd REQUEST (FILE DOWNLOAD)
		$contents = curl_exec($ch);
		
		if(!$contents) {
			$this->echoMessage('Content came up empty.');
			return false;
		}
		
		$this->echoMessage('File downloaded');
		
    	// CLOSE CURL
		curl_close ($ch); 
    	
    	return $contents;
    }
    
    /**
     * Check if a url is alive and valid
     *
     */
    protected function httpFileExists($url){
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_MAXREDIRS, self::MAX_ATTEMPTS);
	    curl_setopt($ch, CURLOPT_NOBODY,1);//Set to HEAD & Exclude body
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);  
	    return $code == 200;
	}
	
	
	/**
	 * Return a remote file info
	 * @return array
	 */
	protected function getHTTPInfo($url) {
	    $c = curl_init();
	    curl_setopt($c, CURLOPT_URL,$url);
	    curl_setopt($c, CURLOPT_HEADER,1);//Include Header In Output
	    curl_setopt($c, CURLOPT_NOBODY,1);//Set to HEAD & Exclude body
	    curl_setopt($c, CURLOPT_RETURNTRANSFER,1);//No Echo/Print
	    curl_setopt($c, CURLOPT_MAXREDIRS, self::MAX_ATTEMPTS);
	    curl_setopt($c, CURLOPT_FILETIME, true);
	    curl_setopt($c, CURLOPT_TIMEOUT,10);
	    $result = curl_exec($c);
	    if($result !== FALSE)
	    {
	    	return curl_getinfo($c);
	    }
	 
		return false;
	}
    
    /**
     * Finish this process
     * @prarm object $supplier
     */
    protected function finishAndMark($supplier) {
    	$this->echoMessage('Finishing this supplier process');
    	$supplier->is_started = 0;
    	$supplier->last_run = time();
    	$supplier->update();
    }
    
    /**
     * Finish this process
     * @prarm object $supplier
     */
    protected function retryMark($supplier) {
    	$this->echoMessage(sprintf("Could not connect to the remote source. Going to sleep will try again in %s seconds", self::SLEEP_TIME));
    	$supplier->is_started = 0;
    	$supplier->update();
    	
    	$this->echoMessage(sprintf("Retry #%s", self::$attempts));
    	
    	// Start counting
    	$count = self::SLEEP_TIME;
    	for($i=1; $i<=self::SLEEP_TIME; $i++) {
    		$this->echoMessage('Retry In ' . $count);
    		$count--;
    		sleep(1);
    	}
    	
    	// Now run it again
    	$retries = self::$attempts + 1;
    	$this->actionBySupplier($supplier->id, $retries);
    }
    
    /**
     * Return a single supplier object to process
     *
     */
    protected function getSupplier($supplierId) {
    	if(self::IN_DEV) {
    		return Supplier::model()->findByPk($supplierId);
    	}
    	return Supplier::model()->notStarted()->nextClosestRun()->orderByLastRun()->findByPk($supplierId);
    }
    
    /**
     * Echos message to the screen and logs to a file if needed
     * @param @message
     */
    protected function echoMessage($message) {
    	echo $message . "\n";
    	if(self::SAVE_INFO_MESSAGES) {
    		$file = sprintf(self::INFO_MESSAGE_FILE, date('m_d_Y'));
    		if(!is_dir(Yii::getPathOfAlias('application.runtime.logs'))) {
    			@mkdir(Yii::getPathOfAlias('application.runtime.logs'));
    		}
    		$comment = sprintf("[%s] %s\n", date('D M Y H.i'), $message);
    		file_put_contents( Yii::getPathOfAlias('application.runtime.logs') . '/' . $file, $comment, FILE_APPEND );
    	}
    }

	/**
     * Echos error message to the screen and logs to a file if needed
     * @param @message
     */
    protected function errorMessage($message) {
    	echo $message . "\n";
    	if(self::SAVE_ERROR_MESSAGES) {
    		$file = sprintf(self::ERROR_MESSAGE_FILE, date('m_d_Y'));
    		if(!is_dir(Yii::getPathOfAlias('application.runtime.logs'))) {
    			@mkdir(Yii::getPathOfAlias('application.runtime.logs'));
    		}
    		$comment = sprintf("[%s] %s\n", date('D M Y H.i'), $message);
    		file_put_contents( Yii::getPathOfAlias('application.runtime.logs') . '/' . $file, $comment, FILE_APPEND );
    	}
    }
    
    /**
     * Get the files path
     *
     */
    protected function getFilesPath() {
    	return Yii::getPathOfAlias('application.runtime.temp');
    }
    
    /**
     * Make sure to check requirements first
     *
     */
    protected function checkRequirements() {
    	// Make sure curl instaled
    	if(!function_exists('curl_init')) {
    		$this->errorMessage('CURL must be installed and enabled!');
    		return false;
    	}
    	
    	// Make sure ftp exists instaled
    	if(!function_exists('ftp_connect')) {
    		$this->errorMessage('PHP FTP extension must be installed and enabled!');
    		return false;
    	}
    	
    	// Make sure imap instaled
    	if(!function_exists('imap_open')) {
    		$this->errorMessage('PHP Imap extension must be installed and enabled!');
    		return false;
    	}
    	
    	// Make sure zip instaled
    	if(!class_exists('ZipArchive')) {
    		$this->errorMessage('ZipArchive must be installed and enabled!');
    		return false;
    	}
    	
    	return true;
    }
}

?>