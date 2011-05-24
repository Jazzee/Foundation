<?php
namespace Foundation\Virtual;

/**
 * Virtual File
 * 
 * Used to create a File when all we have is the binary contents
 * @author Jonathan Johnson <jon.johnson@ucsf.edu>
 *
 */
class VirtualFile extends AbstractFile
{
  /**
   * The contents of the file
   * @var string
   */
  protected $_fileContents;
  
  /**
   * The last modified object
   * @var \DateTime
   */
  protected $_lastModified;
  
  /**
   * Constructor
   * @param string $name
   * @param string $fileContents
   * @param string $lastModified
   */
  public function __construct($name, $fileContents, $lastModified = 'now') {
    parent::__construct($name);
    $this->_fileContents = $fileContents;
    $this->_lastModified = new \DateTime($lastModified);
  }
  
  /**
   * Get File Contents
   * Read the file from the filesystem
   * @see Foundation\Virtual.File::getFileContents()
   */
  public function getFileContents() {
    return $this->_fileContents;
  }
  
  /**
   * Get last Modified date from the file system
   * @see Foundation\Virtual.File::getLastModified()
   */
  public function getLastModified() {
    return $this->_lastModified;
  }
}