<?php
require_once __DIR__ . '/../../bootstrap.php';;

class FormElementHiddenInputTest extends TestCase{
  protected $field;
  
  public function setUp(){
    $form = new \Foundation\Form();
    $this->field = $form->newField();
  }
  function testHidden(){
    $object = new \Foundation\Form\Element\HiddenInput($this->field);
    $this->assertEquals('hidden',$object->getType());
    $object->setType('hidden');
  }
  function testTypeOverridable(){
    $this->setExpectedException('\Foundation\Exception');
    $object = new \Foundation\Form\Element\HiddenInput($this->field);
    $object->setType('text');
  }
  
}