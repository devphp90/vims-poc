<?php
/**
 * Extension class for FTPClient to add some missing functions.
 * Kept separate to allow for FTPClient updates/improvements to be done without affecting this class.
 *
 * @author Shai Bar-Noy
 * @version 0.1
*/
class FTPClientEx extends FTPClient {
	
	public function lastModifiedTime($file) {
		if(!$this->connected)
			throw new FTPException('Could not retrieve directory listing: not connected to remote FTP server');
		if(!$file)
			throw new FTPException('No file name provided to lastModifiedTime method');
 
		return ftp_mdtm($this->resource, $file);
	}
	
	public function fileSize($file) {
		if(!$this->connected)
			throw new FTPException('Could not retrieve directory listing: not connected to remote FTP server');
		if(!$file)
			throw new FTPException('No file name provided to fileSize method');
 
		return ftp_size($this->resource, $file);
	}
 
	
}
?>