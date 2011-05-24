<?php
namespace Foundation\Virtual;
/**
 * Proxy Directory
 */
class ProxyDirectory implements Directory
{
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
    $this->_absolutePath = $absolutePath;
    $this->_virtualDirectory = false;
  }
  
  /**
   * Load the resource as a VirtualDirectory and search it for files
   * @see Foundation\Virtual.Directory::find()
   */
  public function find($pathName){
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