<?php
require_once __DIR__ . '/../bootstrap.php';;

class FormInputTest extends TestCase{
  function test(){
    $arr = array();
    for($i=1;$i<5;$i++){
      $arr[$i] = uniqid();
    }
    $object = new \Foundation\Form\Input($arr);
    
    foreach($arr as $key=>$value) $this->assertEquals($value, $object->get($key));
  }
  
  
  
}