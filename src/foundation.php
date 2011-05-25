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
$requiredIncludes = array('Log.php','Mail.php', 'Doctrine/Common/ClassLoader.php');

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
if(!class_exists('Mail')){
  throw new Exception('Pear Mail is required and it is not availalble');
}
if(!class_exists('imagick')){
  throw new Exception('PECL/Imagick is required and it is not availalble');
}
if(!class_exists('\Doctrine\Common\ClassLoader')){
  throw new Exception('Doctrine > 2.0 is required and it is not availalble');
}

//load the helper functions
require_once('functions.php');

//Register the doctrine class loader
$doctrineClassLoader = new Doctrine\Common\ClassLoader('Doctrine');
$doctrineClassLoader->register();

//Register the foundation class loader
$doctrineClassLoader = new Doctrine\Common\ClassLoader('Foundation', __DIR__);
$doctrineClassLoader->register();

//load lightVC
require_once(dirname(__FILE__) . '/lib/lightvc/lightvc.php');

//load the portable password hasher
require_once(dirname(__FILE__) . '/lib/phpass/PasswordHash.class.php');

/*
//Create virtual paths to foundation resources
$virtualResources = Resource::getInstance();
$virtualResources->addDirectory(dirname(__FILE__) . '/javascript/', 'foundation/scripts');
$virtualResources->addDirectory(dirname(__FILE__) . '/media/famfamfam_silk_icons_v013/icons', 'foundation/icons/');
$virtualResources->addDirectory(dirname(__FILE__) . '/media/cc_images', 'foundation/cc_images/');

$virtualResources->add(dirname(__FILE__) . '/lib/jquery/jquery-1.4.4.min.js', 'foundation/scripts/jquery.js');
$virtualResources->add(dirname(__FILE__) . '/lib/jquery/plugins/jquery.json-2.2.min.js', 'foundation/scripts/jquery.json.js');
$virtualResources->add(dirname(__FILE__) . '/lib/jquery/plugins/jquery.cookie-1.min.js', 'foundation/scripts/jquery.cookie.js');
$virtualResources->add(dirname(__FILE__) . '/lib/jquery/jquery-ui-1.8.11.min.js', 'foundation/scripts/jqueryui.js');
$virtualResources->addDirectory(dirname(__FILE__) . '/lib/jquery/themes/', 'foundation/styles/jquery/themes');
$virtualResources->add(dirname(__FILE__) . '/lib/yui/base-min.css', 'foundation/styles/base.css');
$virtualResources->add(dirname(__FILE__) . '/lib/yui/reset-fonts-grids-min.css', 'foundation/styles/reset-fonts-grids.css');
*/
?>
