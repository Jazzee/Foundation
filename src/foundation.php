<?php
/**
 * Jazzee Foundation Bootstrap
 * Complete basic setup for Jazzee\Foundation
 * Checks PHP version
 * Checks for required PEAR Includes
 * Sets up LIbraries
 * @package Jazzee\Foundation
 */
 
//check dependencies
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
  throw new Exception('You are using PHP version ' . PHP_VERSION . '.  Jazzee\Foundation requires PHP version 5.3.0 or higher.');
}
$requiredIncludes = array('Log.php', 'Doctrine/Common/ClassLoader.php');

foreach(explode(PATH_SEPARATOR, get_include_path()) as $dir){
  foreach($requiredIncludes as $file){
    if(file_exists($dir . '/' . $file)){
      include_once($file);
    }
  }
}
if(!class_exists('Log')){
  throw new Exception('Pear Log is required and it is not availalble');
}
if(!class_exists('imagick')){
  throw new Exception('PECL/Imagick is required and it is not availalble');
}
if(!class_exists('\Doctrine\Common\ClassLoader')){
  throw new Exception('Doctrine > 2.1 is required and it is not availalble');
}

//user our classloader
require_once (__DIR__ . '/Foundation/ClassLoader.php');

//load the helper functions
require_once('functions.php');

//Register the doctrine class loader
$doctrineClassLoader = new \Foundation\ClassLoader('Doctrine');
$doctrineClassLoader->register();

if (version_compare(\Doctrine\ORM\Version::VERSION, '2.1', '<')){
  throw new Exception('At least Doctrine 2.1.0 is required you are running version ' . \Doctrine\ORM\Version::VERSION);
}

//Register the foundation class loader
$doctrineClassLoader = new \Foundation\ClassLoader('Foundation', __DIR__);
$doctrineClassLoader->register();

//load lightVC
require_once(__DIR__ . '/../lib/lightvc/lightvc.php');

//load the portable password hasher
require_once(__DIR__ . '/../lib/phpass/PasswordHash.class.php');

?>
