<?php
require_once __DIR__ . '/bootstrap.php';;

class VirtualRealFileTest extends TestCase{
  function testRead(){
    $file = new \Foundation\Virtual\RealFile('test', realpath(__FILE__));
    $contents = file_get_contents(realpath(__FILE__));
    $this->assertEquals($contents, $file->getFileContents());
  }
  
}