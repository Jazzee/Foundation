<?php
require_once __DIR__ . '/../../bootstrap.php';;
class TestFormElementInput extends \Foundation\Form\Element\Input{
  
}

class FormElementInputTest extends TestCase{
  protected $field;
  
  public function setUp(){
    $form = new \Foundation\Form();
    $this->field = $form->newField();
  }
  function testDefaultAttributes(){
    $object = new TestFormElementInput($this->field);
    $this->assertNull($object->getDisabled());
    $this->assertEquals('text',$object->getType());
    $this->assertNull($object->getMaxLength());
    
  }
    
  function testSetProperties(){
    $object = new TestFormElementInput($this->field);
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