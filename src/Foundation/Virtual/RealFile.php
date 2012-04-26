<?php
namespace Foundation\Virtual;
/**
 * A physical file
 * 
 * @package Foundation\virtual
 */
class RealFile extends AbstractFile
{
  /**
   * The Absolute path to the file
   * @var string
   */
  protected $_absolutePath;

  /**
   * The contents of the file
   * @var string
   */
  protected $_fileContents;

  /**
   * Constructor
   * @param string $name
   * @param string $absolutePath
   */
  public function __construct($name, $absolutePath)
  {
    parent::__construct($name);
    if (
      !$this->_absolutePath = \realpath($absolutePath) or
      !\is_readable($this->_absolutePath)
    ) {
      throw new \Foundation\Exception("Unable to read '{$absolutePath}'.");
    }
    $this->_fileContents = false;
  }

  /**
   * Get File Contents
   * Read the file from the filesystem
   * @see Foundation\Virtual.File::getFileContents()
   */
  public function getFileContents()
  {
    if (false !== $this->_fileContents) {
      return $this->_fileContents;
    }
    if (!is_readable($this->_absolutePath) or !$this->_fileContents = file_get_contents($this->_absolutePath)) {
      throw new Exception($this->_name, 404);
    }

    return $this->_fileContents;
  }

  /**
   * Get last Modified date from the file system
   * @see Foundation\Virtual.File::getLastModified()
   */
  public function getLastModified()
  {
    $time = filemtime($this->_absolutePath);
    $dt = new \DateTime();
    $dt->setTimestamp($time);

    return $dt;
  }
}