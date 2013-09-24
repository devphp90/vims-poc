<?php
 
/**
 * Wrapper class for php's FTP commands. Allows programmers to use php's FTP commands
 * in an object oriented way. This class requires php's FTP extension.
 *
 * @author Michiel van der Velde <michiel@michielvdvelde.nl>
 * @version 0.2
*/
class FTPClient
{
	/**
	 * Constant which identifies the transfer mode as ASCII
	*/
	const	MODE_ASCII		=	FTP_ASCII;
 
	/**
	 * Constant which identifies the transfer mode as binary
	*/
	const	MODE_BINARY		=	FTP_BINARY;
 
	private	$host;
	private	$port			=	21;
	private	$timeout		=	5;
 
	private	$user;
	private	$password;
 
	private	$resource;
	private	$workingDir;
	private	$connected		=	false;
	private	$passive		=	false;
 
	/**
	 * Creates a new instance of the FTPClient class
	 *
	 * @param $host The host (IP/name) FTP server to connect to (optional)
	 * @param $port The port to connect to (optional, defaults to port 21)
	*/
	public function __construct($host = null, $port = null)
	{
		// Make sure ftp extension installed and enabled
		if(!function_exists('ftp_connect')) {
			throw new FTPException('The PHP ftp extension is not installed or not enabled.');
		}
		
		if($host != null)
			$this->setHost($host);
		if($port != null)
			$this->setPort($port);
	}
 
	/**
	 * Connects to the FTP server
	 *
	 * @param $user The user name for login
	 * @param $password The password for login
	*/
	public function connect($user = null, $pass = null)
	{
		if($user != null)
			$this->setUser($user);
		if($pass != null)
			$this->setPassword($pass);
 
		// Check if all credentials (host, port, user and password) are given
		if($this->host == null)
				throw new FTPException('Unable to connect: host not set');
		if($this->port == null)
				throw new FTPException('Unable to connect: port not set');
		if($this->user == null)
				throw new FTPException('Unable to connect: user name not set');
		if($this->password == null)
				throw new FTPException('Unable to connect: password not set');
 
		// Connect and login
		if(!($this->resource = ftp_connect($this->host, $this->port, $this->timeout)))
			throw new FTPException('Unable to connect: no connection established (timed out?)');
		if(!@ftp_login($this->resource, $this->user, $this->password))
			throw new FTPException('Unable to log in: user name or password invalid');
		$this->workingDir = ftp_pwd($this->resource);
		$this->connected = true;
	}
 
	/**
	 * Sets the connection to passive (TRUE) or active (FALSE) mode
	 *
	 * @param $passive TRUE to change to passive mode, FALSE to change to active mode
	*/
	public function setPassive($passive)
	{
		if(!$this->connected)
			throw new FTPException('Could not change passive mode: not connected to remote FTP server');
 
		if($this->passive != $passive)
		{
			if(!ftp_pasv($this->resource, $passive))
					throw new FTPException('Could not change passive mode: unknown error');
			$this->passive = $passive;
		}
	}
 
	/**
	 * Returns a list of directories and files. When <code>$directory</code> is not set (FALSE, default),
	 * the current working directory is used.
	 *
	 * @return array An array containing the directories and files
	*/
	public function listFiles($directory = false)
	{
		if(!$this->connected)
			throw new FTPException('Could not retrieve directory listing: not connected to remote FTP server');
		if(!$directory)
			$directory = $this->getWorkingDir();
 
		return ftp_nlist($this->resource, $directory);
	}
 
	/**
	 * Changes the current working directory
	 *
	 * @param $newDirectory The directory to make the new working directory
	*/
	public function changeDir($newDirectory)
	{
		if(!$this->connected)
			throw new FTPException('Could not change working directory: not connected to remote FTP server');
 
		if(!@ftp_chdir($this->resource, $newDirectory))
			throw new FTPException('Unable to change directory: directory does not exist');
 
		$this->workingDir = $newDirectory;
	}
 
	/**
	 * Gets a file from the FTP server. With larger files, this method blocks until the whole
	 * file is downloaded. This is something to keep in mind with larger files and PHP's default 
	 * time out of 30 seconds. Use <code>set_time_limit</code> to allow the script to execute
	 * longer than 30 seconds in the case of large files.
	 *
	 * @param $localFile The file path and name to store the remote file to
	 * @param $remoteFile The file path and name of the remote file to download
	 * @param $mode The transfer mode. Can be either FTPClient::MODE_ASCII (text, default) or FTPCLIENT::MODE_BINARY (images etc)
	 * @param $overwrite Whether or not to overwrite if the file already exists (defaults to false)
	*/
	public function downloadFile($localFile, $remoteFile, $mode = self::MODE_ASCII, $overwrite = false)
	{
		if(!$this->connected)
			throw new FTPException('Could not download file: not connected to remote FTP server');
		if(file_exists($localFile) && $overwrite == false)
			throw new FTPexception('Could not download file: local file already exists and overwriting is disabled');
 
		// Get the file path without the file name itself
		$parts = explode('/', $localFile);
		unset($parts[count($parts)-1]);
		$filePath = implode('/', $parts);
 
		if(!is_dir($filePath))
			throw new FTPException('Could not download file: local directory does not exist');
		if(!is_writable($filePath))
			throw new FTPException('Could not download file: local directory is not writable');
 
		if(!$this->fileExists($remoteFile))
			throw new FTPException('Could not download file: remote file does not exist');
 
		// Get the remote file from the FTP server
		if(!@ftp_get($this->resource, $localFile, $remoteFile, $mode))
			throw new FTPException('Could not download file: unknown error');
	}
 
	/**
	 * Uploads a file to the FTP server to the specified location. With larger files,
	 * this method blocks until the whole file is uploaded. This is something to keep
	 * in mind with larger files and PHP's default time out of 30 seconds. Use <code>set_time_limit</code>
	 * to allow the script to execute longer than 30 seconds in the case of large files.
	 *
	 * @param $localFile The file path and name of the file to upload
	 * @param $remoteFile The file path and name of the file to upload the local file to
	 * @param $mode The transfer mode. Can be either FTPClient::MODE_ASCII (text, default) or FTPClient::MODE_BINARY (images etc)
	 * @param $overwrite Whether or not to overwrite if the file already exists on the server (defaults to false)
	*/
	public function uploadFile($localFile, $remoteFile, $mode = self::MODE_ASCII, $overwrite = false)
	{
		if(!$this->connected)
			throw new FTPException('Could not upload file: not connected to remote FTP server');
		if(!file_exists($localFile))
			throw new FTPException('Could not upload file: local file does not exist');
 
		if($this->fileExists($remoteFile) && $overwrite == false)
			throw new FTPException('Could not upload file: remote file already exists');
 
		if(!ftp_put($this->resource, $localFile, $remoteFile, $mode))
			throw new FTPException('Could not upload file: unknown error');
	}
 
	/**
	 * Returns TRUE if the specified directory exists on the FTP server
	 *
	 * @param $directory The directory to check for
	 * @return boolean TRUE if directory exists, FALSE if it doesn't
	*/
	public function directoryExists($directory)
	{
		if(!$this->connected)
			throw new FTPException('Could not check for directory existence: not connected to remote FTP server');
 
		if(!ftp_chdir($this->resource, $directory))
			return false;
 
		ftp_chdir($this->resource, $this->workingDir);
		return true;
 
	}
 
	/**
	 * Creates a new directory on the FTP server. The FTP user needs
	 *
	 * to have the correct permissions to do so.
	 * @param $directory The directory to create
	*/
	public function createDirectory($directory)
	{
		if(!$this->connected)
			throw new FTPException('Could not create directory: not connected to remote FTP server');
		if($this->directoryExists($directory))
			throw new FTPException('Could not create directory: directory already exists');
 
		if(!ftp_mkdir($this->resource, $directory))
			throw new FTPException('Unable to create new directory \''.$directory.'\'');
	}
 
	/**
	 * Returns TRUE if the file exists on the FTP server
	 *
	 * @param $file The file to check for
	 * @return boolean TRUE if the file exists, FALSE if it doesn't
	*/
	public function fileExists($file)
	{
		if(!$this->connected) {
			throw new FTPException('Could not check for file existence: not connected to remote FTP server');
 		}
 		
 		// Get all files in the current dir
 		$file_ = $file;
 		$files = $this->listFiles();
 		$filename = end(explode('/', $file_));
 		// Remove ./ | / | . in front of the file names
 		foreach($files as $k => $r) {
 			// Remove stuff
 			$r = preg_replace('~^(./|/|.)~', '', $r);
 			$files[$k] = $r;
 		}
 		// Now check
 		if(in_array($filename, $files)) {
 			return true;
 		}
 
		// If not found return false
		return false;
	}
	
	/**
	 * Get remote file time
	 * @return time
	 */
	public function getRemoteFileTime($file) {
		if(!$this->connected) {
			throw new FTPException('Could not check for file time: not connected to remote FTP server');
 		}
 		$time = ftp_mdtm($this->resource, $file);
		return $time;
	}
 
	/**
	 * Changes the permissions on the given file
	 *
	 * @param $fileName The file to change permissions on
	 * @param $mode The octal value for the new permissions (e.g. 0644)
	*/
	public function chmod($fileName, $mode)
	{
		if(!$this->connected)
			throw new FTPException('Could not modify file permissions: not connected to remote FTP server');
 
		if(!ftp_chmod($this->resource, $mode, $fileName))
			throw new FTPException('Permission change (chmod) failed');
	}
 
	/**
	 * Deletes a file from the FTP server
	 *
	 * @param $fileName The path and name of the file to delete
	*/
	public function deleteFile($fileName)
	{
		if(!$this->connected)
			throw new FTPException('Could not delete file: not connected to remote FTP server');
 
		if(!ftp_delete($this->resource, $fileName))
			throw new FTPException('Could not delete file: unknown error');
	}
 
	/**
	 * Deletes a directory from the FTP server. If <code>$deleteNotEmpty</code> is set to FALSE (default),
	 * the directory will not be removed if it is not empty. If <code>$deleteNotEmpty</code> is set to TRUE,
	 * this method will empty the directory and remove any directories and files in it.
	 *
	 * @param $directoryName The directory path and name to delete
	 * @param $deleteNotEmpty If set to TRUE, all files and directories will be deleted (default FALSE)
	*/
	public function deleteDirectory($directoryName, $deleteNotEmpty = false)
	{
		if(!$this->connected)
			throw new FTPException('Could not delete directory: not connected to remote FTP server');
		if(!$this->directoryExists($directoryName))
			throw new FTPException('Could not delete directory: specified directory does not exist');
 
		if($deleteNotEmpty)
		{
			foreach($this->listFiles() as $file)
			{
				if($this-fileExists($file))
					$this->deleteFile($directoryName . '/' . $file);
				if($this->directoryExists($file))
					$this->deleteDirectory($directoryName . '/' . $file);
			}
		}
		if(!ftp_rmdir($this->resource, $fileName))
		{
			if(!$deleteNotEmpty)
				throw new FTPException('Could not delete directory: directory is not empty');
			else
				throw new FTPException('Could not delete directory: unknown error');
		}
	}
 
	// -------------------------------
 
	/**
	 * Sets the host (IP) address of the FTP server to connect to
	 *
	 * @param $host The (IP) address of the FTP server
	*/
	public function setHost($host)
	{
		if($this->connected)
			throw new FTPException('Unable to set host: open connnection');
 
		$this->host = $host;
	}
 
	/**
	 * Sets the host port of the FTP server to connect to
	 *
	 * @param $port The host port
	*/
	public function setPort($port)
	{
		if($this->connected)
			throw new FTPException('Unable to set port: open connnection');
 
		$this->port = $port;
	}
 
	/**
	 * Sets the user name to use for authentication on the FTP server
	 *
	 * @param $user The user name
	*/
	public function setUser($user)
	{
		if($this->connected)
			throw new FTPException('Unable to set user: open connnection');
 
		$this->user = $user;
	}
 
	/**
	 * Sets the password to use for authentication on the FTP server
	 *
	 * @param $password The password
	*/
	public function setPassword($password)
	{
		if($this->connected)
			throw new FTPException('Unable to set password: open connnection');
 
		$this->password = $password;
	}
 
	/**
	 * Sets the timeout for the FTP connection
	 *
	 * @param The timeout
	*/
	public function setTimeout($timeout)
	{
		if($this->connected)
			throw new FTPException('Unable to set timeout: open connnection');
 
		$this->timeout = $timeout;
	}
 
	// -------------------------------
 
	/**
	 * Gets the host (IP) address of the FTP server to connect to
	*/
	public function getHost()
	{
		return $this->host;
	}
 
	/**
	 * Gets the host port of the FTP server to connect to
	*/
	public function getPort()
	{
		return $this->port;
	}
 
	/**
	 * Gets the user name to use for authentication on the FTP server
	*/
	public function getUser()
	{
		return $this->user;
	}
 
	/**
	 * Gets the password to use for authentication on the FTP server
	*/
	public function getPassword()
	{
		return $this->password;
	}
 
	/**
	 * Gets the timeout for the FTP connection
	*/
	public function getTimeout()
	{
		return $this->timeout;
	}
 
	/**
	 * Returns the current working directory
	*/
	public function getWorkingDir()
	{
		return $this->workingDir;
	}
 
	/**
	 * Returns TRUE if the connection is passive, FALSE otherwise
	*/
	public function getPassive()
	{
		return $this->passive;
	}
 
	// -------------------------------
 
	/**
	 * Get the full path to the specified directory. If <code>$relative</code> is set
	 * to TRUE, the working directory will be prepended to the path.
	 *
	 * @param $path The (relative) path to convert
	 * @param $relative If TRUE (default), the full path including the working directory is returned
	 * @return string The full path to the specified directory
	*/
	protected function getFullServerPathDir($path, $relative = true)
	{
		$newPath = '/';
		if($relative)
			$newPath = $this->workingDir;
 
		if(substr($path, -1) != '/')
			$path .= '/';
		if(substr($path, 0, 1) == '/')
			$path = substr($path, 1);
 
		$newPathParts = array();
		foreach(explode('/', $newPath . $path) as $pathPart)
		{
			if($pathPart == '..' && count($newPathParts) > 0)
				unset($newPathParts[count($newPathParts)-1]);
			else
				$newPathParts[] = $pathPart;
		}
		return implode('/', $newPathParts);
	}
 
	/**
	 * Get the full path to the specified file. If <code>$relative</code> is set
	 * to TRUE, the full path, including the current working directory will be returned.
	 *
	 * @param $path The (relative) path to convert
	 * @param $relative If TRUE (default), the full path including the working directory is returned
	 * @return string The full path to the specified file
	*/
	protected function getFullServerPathFile($path, $relative = true)
	{
		$pathParts = explode('/', $path);
		$file = $pathParts[count($pathParts)-1];
		unset($pathParts[count($pathParts)-1]);
 
		return $this->getFullServerPathDir(implode('/', $pathParts), $relative) . $file;
	}
 
	/**
	 * Disconnects from the FTP server
	*/
	public function disconnect()
	{
		if(!$this->connected || $this->resource == null)
			throw new FTPException('Could not disconnect: no open connection');
		else
		{
			ftp_close($this->resource);
			$this->resource = null;
		}
	}
}
 
/**
 * This class is the exception class for the FTPClient class. It extends the standard
 * Exception class
*/
class FTPException extends Exception { }