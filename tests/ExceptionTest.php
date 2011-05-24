<?php
require_once __DIR__ . '/bootstrap.php';;

class ExceptionTest extends TestCase{
  function testNew(){
    $this->setExpectedException('Foundation\Exception');
    throw new Foundation\Exception();
  }
  function testMessage(){
    $baseMessage = uniqid();
    $code = rand();
    $userMessage = uniqid();
    try{
      throw new Foundation\Exception($baseMessage, $code, $userMessage);
    } catch (Foundation\Exception $e) {
      $this->assertEquals($e->getMessage(), $baseMessage);
      $this->assertEquals($e->getCode(), $code);
      $this->assertEquals($e->getUserMessage(), $userMessage);
    }
  }
  
  


}