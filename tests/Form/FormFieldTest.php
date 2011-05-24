<?php
require_once __DIR__ . '/../bootstrap.php';;

class FormFieldTest extends TestCase{
  protected $form;
  public function setUp(){
    $this->form = new \Foundation\Form();
  }
  
  function testDefaultAttributes(){
    $field = new \Foundation\Form\Field($this->form);
    $elements = $field->getElements();
    $this->assertTrue(empty($elements));
  }
  
  function testNewElement(){
    $field = new \Foundation\Form\Field($this->form);
    $element = $field->newElement('TextInput', 'test');
    $this->assertContains($element, $field->getElements());
  }
  
  function testGetElements(){
    $field = new \Foundation\Form\Field($this->form);
    $elements = array();
    for($i=0;$i<20;$i++){
      $elements[] = $field->newElement('TextInput', $i);
    }
    foreach($elements as $element){
      $this->assertContains($element, $field->getElements());
    }
    
  }
  
  function testBadNewElement(){
    $this->setExpectedException('\Foundation\Exception');
    $field = new \Foundation\Form\Field($this->form);
    $field->newElement('NO_ELEMENT_NAME', 'test');
  }
  
  function testAddElement(){
    $field = new \Foundation\Form\Field($this->form);
    $element = new \Foundation\Form\Element\Textarea($field);
    $field->addElement($element);
    $this->assertContains($element, $field->getElements());
  }
  
}