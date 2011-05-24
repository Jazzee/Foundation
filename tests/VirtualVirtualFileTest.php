<?php
require_once __DIR__ . '/bootstrap.php';;

class VirtualVirtualFileTest extends TestCase{
  function testRead(){
    $contents = file_get_contents(realpath(__FILE__));
    $file = new \Foundation\Virtual\VirtualFile('test', $contents);
    $this->assertEquals($contents, $file->getFileContents());
    
  }
  
}