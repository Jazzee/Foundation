<?php
namespace Foundation\Virtual;
/**
 * Proxy Directory
 * @package foundation\virtual
 */
class ProxyDirectory implements Directory
{
  /**
   * Array of absolute file system paths keyed by virtual path
   * @var array
   */
  protected $_files;
  
  /**
   * @var string the file system path
   */
  protected $_absolutePath;
  
  /**
   * @var the VirtualDirectory we represent
   */
  protected $_virtualDirectory;
 
  /**
   * Constructor
   * @param string $absolutePath;
   */
  public function __construct($absolutePath){
    $this->_files = array();
    if(
      !$this->_absolutePath = \realpath($absolutePath) 
      or !\is_dir($this->_absolutePath) 
      or !\is_readable($this->_absolutePath)) 
        throw new \Foundation\Exception("Unable to read '{$absolutePath}' directory.");
    $this->_virtualDirectory = false;
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
   * Load the resource as a VirtualDirectory and search it for files
   * @see Foundation\Virtual.Directory::find()
   */
  public function find($pathName){
    if(\array_key_exists($pathName, $this->_files)) return $this->_files[$pathName];
    
    if(false != $this->_virtualDirectory) return $this->_virtualDirectory->find($pathName);
    $this->_virtualDirectory = new VirtualDirectory();
    
    $dir = new \DirectoryIterator($this->_absolutePath);
    foreach($dir as $file){
      if(!$file->isDot() and $file->isReadable()){
        if($file->isFile()){
          $this->_virtualDirectory->addFile($file->getFilename(), new RealFile($file->getFilename(),$file->getPathName()));
        } else if($file->isDir()){
          $this->_virtualDirectory->addDirectory($file->getFilename(), new ProxyDirectory($file->getPathName()));
        }
      }
    }
    return $this->find($pathName);
  }
  
}