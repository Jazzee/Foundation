<?php
require_once __DIR__ . '/bootstrap.php';;

class NavigationLinkText extends TestCase{
  
  function testDefaultAttributes(){
    $object = new \Foundation\Navigation\Link('');
    $this->assertNull($object->getCharset());
    $this->assertNull($object->getCoords());
    $this->assertNull($object->getHref());
    $this->assertNull($object->getHreflang());
    $this->assertNull($object->getName());
    $this->assertNull($object->getRel());
    $this->assertNull($object->getRev());
    $this->assertNull($object->getShape());
    
  }
  
  function testSetProperties(){
    $text = uniqid();
    $object = new \Foundation\Navigation\Link($text);
    
    $this->assertEquals($text, $object->getText());
    $value = uniqid();
    foreach($object->getAttributes() as $memberName => $htmlName){
      $set = 'set' . ucfirst($memberName);
      $object->$set($value);
    }
    foreach($object->getAttributes() as $memberName => $htmlName){
      $get = 'get' . ucfirst($memberName);
      $this->assertEquals($value, $object->$get(), "Wrong value for {$memberName}");
    }
    
  }
  
}