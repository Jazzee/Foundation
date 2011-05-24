<?php
use Foundation\Virtual\RealFile;
require_once __DIR__ . '/bootstrap.php';;

class VirtualDirectoryTest extends TestCase{
  function testRead(){
    $contents = file_get_contents(realpath(__FILE__));
    
    $directory = new \Foundation\Virtual\ProxyDirectory(\realpath(__DIR__ . '/../'));
    
    $file = $directory->find('tests/VirtualProxyDirectoryTest.php');
    $this->assertTrue($file instanceof \Foundation\Virtual\File);
    $this->assertEquals($contents, $file->getFileContents());
  }
  
  function testMissing(){
    $this->setExpectedException('\Foundation\Exception');
    $directory = new \Foundation\Virtual\ProxyDirectory(\realpath(__DIR__ . '/../'));
    $file = $directory->find('NOFILE.none');
  }
  
}