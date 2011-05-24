<?php
namespace Foundation\Virtual;
/**
 * Proxy Directory
 * @package Foundation\Virtual
 */
class ProxyDirectory implements Directory{
  /**
   * @var string the file system path
   */
  protected $absolutePath;
  
  /**
   * @var the VirtualDirectory we represent
   */
  protected $virtualDirectory;
 
  /**
   * Constructor
   * @param string $absolutePath;
   */
  public function __construct($absolutePath){
    $this->absolutePath = $absolutePath;
    $this->virtualDirectory = false;
  }
  
  /**
   * Load the resource as a VirtualDirectory and search it for files
   * @see Foundation\Virtual.Directory::find()
   */
  public function find($pathName){
    if(false != $this->virtualDirectory) return $this->virtualDirectory->find($pathName);
    $this->virtualDirectory = new VirtualDirectory();
    
    $dir = new \DirectoryIterator($this->absolutePath);
    foreach($dir as $file){
      if(!$file->isDot() and $file->isReadable()){
        if($file->isFile()){
          $this->virtualDirectory->addFile($file->getFilename(), new RealFile($file->getFilename(),$file->getPathName()));
        } else if($file->isDir()){
          $this->virtualDirectory->addDirectory($file->getFilename(), new ProxyDirectory($file->getPathName()));
        }
      }
    }
    return $this->find($pathName);
  }
  
}
?>