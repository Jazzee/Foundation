<?php
use Foundation\Virtual\RealFile;
require_once __DIR__ . '/bootstrap.php';;

class VirtualVirtualDirectoryTest extends TestCase{
  function testRead(){
    $contents = file_get_contents(realpath(__FILE__));
    $directory = new \Foundation\Virtual\VirtualDirectory();
    $directory->addFile('test', new \Foundation\Virtual\RealFile('test',__FILE__));
    
    $file = $directory->find('test');
    
    $this->assertEquals($contents, $file->getFileContents());
    
  }
  
}