<?php
namespace Foundation;
/**
 * ClassLoader
 * Extend Doctrine\Common\ClassLoader to add caching and a check if 
 * we can load the class before we try
 * @package foundation
 */
class ClassLoader extends \Doctrine\Common\ClassLoader{
  public function loadClass($className){
    if($this->canLoadClass($className)) return parent::loadClass($className);
    return false;  
  }
}