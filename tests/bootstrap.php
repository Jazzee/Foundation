<?php
/**
 * Setup Tests
 * 
 */

error_reporting(E_ALL | E_STRICT);

require_once 'Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('', __DIR__);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Foundation',  __DIR__ . '/../src');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
$classLoader->register();

set_include_path(
    __DIR__  . PATH_SEPARATOR . get_include_path()
);

require_once 'TestCase.php';