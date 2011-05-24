<?php
require_once __DIR__ . '/../../bootstrap.php';;

class FormElementTextareaTest extends TestCase{
  protected $field;
  
  public function setUp(){
    $form = new \Foundation\Form();
    $this->field = $form->newField();
  }
  function testDefaultAttributes(){
    $object = new \Foundation\Form\Element\Textarea($this->field);

    $this->assertNull($object->getRows());
    $this->assertNull($object->getCols());
    $this->assertNull($object->getDisabled());
    $this->assertNull($object->getReadonly());
    
  }
    
  function testSetProperties(){
    $object = new \Foundation\Form\Element\Textarea($this->field);
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