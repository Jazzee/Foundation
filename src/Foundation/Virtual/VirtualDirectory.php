<?php
namespace Foundation\Virtual;
/**
 * Virtual Directory
 */
class VirtualDirectory implements Directory
{
  /**
   * Array of absolute file system paths keyed by virtual path
   * @var array
   */
  protected $_files;
  
  /**
   * Array of other Direcotry Objects keyed by virtual path
   */
  protected $_directories;
 
  /**
   * Constructor
   */
  public function __construct() {
    $this->_files = array();
    $this->_directories = array();
  }

  /**
   * Add a virtual path to a physical file
   * Multiple paths can point to the same object and paths can be overridden
   * @param string $virtualName
   * @param AbstractFile $file
   */
  public function addFile($virtualName, File $file) {
    $this->_files[$virtualName] = $file;
  }
  
  /**
   * Add a virtual path to a new directory
   * Multiple paths can point to the same object and paths can be overridden
   * @param string $virtualName
   * @param Directory $directory
   */
  public function addDirectory($virtualName, Directory $directory) {
    $this->_directories[$virtualName] = $directory;
  }
  
  /**
   * Get a virtual directory
   * @param string $virtualName
   * @return Directory
   */
  public function getDirectory($virtualName) {
    return $this->_directories[$virtualName];
  }
  
  
  /**
   * Get a file by searching out paths
   * @param $name
   * @return \Foundation\Virtual\File;
   */
  public function find($name) {
    if(\array_key_exists($name, $this->_files)) return $this->_files[$name];
    //only continue if there is some text left
    if(!empty($name)){
      //break the name down by seperator
      $arr = \explode('/',$name);
      $first = array_shift($arr);
      if(\array_key_exists($first, $this->_directories)) return $this->_directories[$first]->find(\implode('/',$arr));
    } 
    throw new Exception($name, 404);
  }
  
}
?>