<?php
namespace Foundation;
/**
 * ClassLoader
 * Extend Doctrine\Common\ClassLoader to add caching and a check if 
 * we can load the class before we try
 * @package Foundation
 */
class ClassLoader extends \Doctrine\Common\ClassLoader{
  protected $fileExtension = '.php';
  protected $namespace;
  protected $includePath;
  protected $namespaceSeparator = '\\';
  
  public function __construct($ns = null, $includePath = null){
    $this->namespace = $ns;
    $this->includePath = $includePath;
    parent::__construct($ns, $includePath);
  }
    
  public function loadClass($className){
    if($this->canLoadClass($className)) return parent::loadClass($className);
    return false;  
  }
}