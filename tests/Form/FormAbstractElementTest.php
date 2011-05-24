<?php
require_once __DIR__ . '/../bootstrap.php';;
class TestFormElement extends \Foundation\Form\Element\AbstractElement{
  
}

class FormElementTest extends TestCase{
  protected $field;
  
  public function setUp(){
    $form = new \Foundation\Form();
    $this->field = $form->newField();
  }
  function testDefaultAttributes(){
    $object = new TestFormElement($this->field);
    $this->assertNull($object->getName());
    $this->assertNull($object->getValue());
    $this->assertNull($object->getAccessKey());
    $this->assertNull($object->getTabindex());
    $this->assertNull($object->getLabel());

    $messages = $object->getMessages();
    $this->assertTrue(empty($messages));
    
  }
    
  function testSetProperties(){
    $object = new TestFormElement($this->field);
    $value = uniqid();
    foreach($object->getAttributes() as $memberName => $htmlName){
      $set = 'set' . ucfirst($memberName);
      $object->$set($value);
    }
    foreach($object->getAttributes() as $memberName => $htmlName){
      $get = 'get' . ucfirst($memberName);
      $this->assertEquals($value, $object->$get(), "Wrong value for {$memberName}");
    }
    $object->setLabel($value);
    $this->assertEquals($value, $object->getLabel());
  }
  
  
  
}