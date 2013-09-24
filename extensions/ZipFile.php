<?php
 
/**
 * Wrapper class for ZipArchive with exceptions. Provides simple functions
 * to compress, list and extract files or folders (recursively).
 * @package de.atwillys.sw.php.swLib
 * @author Stefan Wilhelm
 * @copyright Stefan Wilhelm, 2007-2010
 * @license GPL
 * @version 1.0
 * @uses ZipException
 *
 */
class ZipFile {
 
    /**
     * The zip object
     * @var ZipArchive
     */
    private $zip = null;
 
    /**
     * Constructor
     * @return ZipFile
     */
    public final function __construct() {
        $this->zip = new ZipArchive();
    }
 
    /**
     * Destructor
     */
    public final function __destruct() {
        $this->close();
    }
 
    /**
     * Throws an ZipException according to the occurred ZipArchive
     * error code.
     * @static
     * @param int $zipArchiveErrorCode
     * @throws ZipException
     * @return void
     */
    private static final function throwZipException($zipArchiveErrorCode) {
        switch($zipArchiveErrorCode) {
            case ZIPARCHIVE::ER_EXISTS:
                throw new ZipException('Zip file already exists');
            case ZIPARCHIVE::ER_OPEN:
                throw new ZipException('Failed to open zip file');
            case ZIPARCHIVE::ER_READ:
                throw new ZipException('Could not read zip file');
            case ZIPARCHIVE::ER_INCONS:
                throw new ZipException('Zip file inconsistent');
            case ZIPARCHIVE::ER_INVAL:
                throw new ZipException('Zip file invalid');
            case ZIPARCHIVE::ER_MEMORY:
                throw new ZipException('Not enough memory to handle zip file');
            case ZIPARCHIVE::ER_NOENT:
                throw new ZipException('Zip file has no entries');
            case ZIPARCHIVE::ER_NOZIP:
                throw new ZipException('File is no zip file');
            case ZIPARCHIVE::ER_SEEK:
                throw new ZipException('Could seek the position in zip file');
            default:
                throw new ZipException('Unknown error occurred handling zip file');
        }
    }
 
    /**
     * Generates a new zip file from a file or a folder. Folders are
     * compressed recursively.
     * @param string $fileOrFolder
     * @param string $zipArchive
     * @return string
     */
    public static function compress($fileOrFolder, $zipArchive) {
        $zip = new self();
        $zip->create($zipArchive);
        try {
            $zip->add($fileOrFolder);
        } catch(Exception $e) {
            $zip->close();
            @unlink($zipArchive);
            throw $e;
        }
        $zip->close();
        return realpath($zipArchive);
    }
 
    /**
     * Extracts a file or folder to a specified location folder.
     * The folder must exist before extracting
     * @param string $zipArchive
     * @param string $folder
     */
    public static function extract($zipArchive, $folder) {
        if(!is_dir($folder)) {
            throw new ZipException('Directory to extract to does not exist');
        } else {
            $zip = new self();
            $zip->open($zipArchive);
            $e = $zip->zip->extractTo($folder);
            if(!$e) {
                $zip->close();
                throw new ZipException('Failed to extract files');
            }
            $zip->close();
        }
    }
 
    /**
     * Returns an assoc. array containing the list of all entries in the zip archive.
     * Each entry is an assoc. array that contains details about the file/folder.
     * @return array
     */
    public static function contents($zipArchive) {
        $zip = new self();
        $zip->open($zipArchive);
        $l = $zip->getContentList();
        $zip->close();
        return $l;
    }
 
    /**
     * Opens a zip file for manipulation and returns
     * the ZipFile object for the opened file.
     * @param string $file
     * @throws ZipException
     * @return void
     */
    public function open($file) {
        if(!is_file($file)) {
            throw new ZipException('Zip file to open does not exist');
        } else if(!is_readable($file)) {
            throw new ZipException('Zip file to open is not readable');
        } else {
            $e = $this->zip->open($file);
            if($e !== true) {
                self::throwZipException($e);
            }
        }
    }
 
    /**
     * Creates and opens a zip file for manipulation and returns
     * the ZipFile object for the created file.
     * @static
     * @param string $file
     * @throws ZipException
     * @return void
     */
    public function create($file) {
        if(is_file($file)) {
            throw new ZipException('Zip file to create already exists');
        } else {
            $e = $this->zip->open($file, ZipArchive::CREATE);
            if($e !== true) {
                self::throwZipException($e);
            }
        }
    }
 
    /**
     * Closes the zip file
     */
    public function close() {
        try {
            @$this->zip->close();
        } catch(Exception $e) {
            // ignore here
        }
    }
 
    /**
     * Adds a file or a directory (recursive) to the zip archive. The $basePath
     * indicates the root directory of the archive. If e.g. $pathToFileOrDir
     * is "/tmp/folder1/folder2/file.txt" and $basePath is "/tmp/folder1", then
     * the file.txt will be in the archive as "/folder2/file.txt".
     * @param string $pathToFileOrDir
     * @param string $basePath
     */
    public function add($pathToFileOrDir, $basePath=null) {
        $pathToFileOrDir = trim($pathToFileOrDir);
        $basePath = trim($basePath);
        Tracer::trace("add '$pathToFileOrDir', basepath '$basePath'");
 
        if(!is_file($pathToFileOrDir) && !is_dir($pathToFileOrDir)) {
            throw new ZipException('File or directory to add does not exist in file system');
        } else {
            if(empty($basePath)) {
                // Assume that the file/directory is to be added to the zip root
                $basePath = dirname($pathToFileOrDir);
            }
            if(stripos($pathToFileOrDir, $basePath) === false) {
                throw new ZipException('The path to the file or directory must include base path');
            }
 
            // Create local path for zip
            if(is_file($pathToFileOrDir)) {
                $localPath = str_ireplace($basePath, '', $pathToFileOrDir);
                // Check if the directory structure already exist in the zip file
                if(dirname($localPath) != '') {
                    $e = $this->zip->addEmptyDir(dirname($localPath));
                    if($e !== true && $e != ZipArchive::ER_EXISTS) {
                        self::throwZipException($e);
                    }
                }
                // Finally add the file
                $e = $this->zip->addFile($pathToFileOrDir, $localPath);
                if($e !== true) {
                    self::throwZipException($e);
                }
            } else if(is_dir($pathToFileOrDir)) {
                // Add a directory
                $content = FileSystem::find($pathToFileOrDir,'*');
                foreach($content as $file) {
                    $localPath = str_ireplace($basePath, '', $file);
                    if(is_dir($file)) {
                        $e = $this->zip->addEmptyDir($localPath);
                        if($e !== true && $e != ZipArchive::ER_EXISTS) {
                            self::throwZipException($e);
                        }
                    } else {
                        $e = $this->zip->addFile($file, $localPath);
                        if($e !== true) {
                            self::throwZipException($e);
                        }
                    }
                }
            }
        }
    }
 
    /**
     * Removes a file or a folder in the zip file
     * @param string $fileOrFolderInZip
     */
    public function remove($fileOrFolderInZip) {
        $fileOrFolderInZip = trim($fileOrFolderInZip);
        if(strlen($fileOrFolderInZip) == 0) {
            throw new ZipException('No file or folder to delete given');
        } else if($fileOrFolderInZip == '/') {
            throw new ZipException('Cannot delete the root of zip file');
        } else {
 
            print "$fileOrFolderInZip\n\n\n";
            if(!$this->zip->deleteName($fileOrFolderInZip)) {
                throw new ZipException('Failed to remove file/folder in zip archive');
            }
        }
    }
 
    /**
     * Returns an assoc. array containing the list of all entries in the zip archive.
     * Each entry is an assoc. array that contains details about the file/folder.
     * @return array
     */
    public function getContentList() {
        $stats = array();
        for($i=0; $i<$this->zip->numFiles; $i++) {
            $stat = $this->zip->statIndex($i);
            if(!is_array($stat)) {
                throw new ZipException('Failed to receive the status or a contained file or folder');
            } else {
                $stats[$stat['name']] = $stat;
            }
        }
        return $stats;
    }
}

/**
 * Exception thrown by class ZipFile
 * @package de.atwillys.sw.php.swLib
 * @author Stefan Wilhelm
 * @copyright Stefan Wilhelm, 2007-2010
 * @license GPL
 * @version 1.0
 */
class ZipException extends Exception {
}
