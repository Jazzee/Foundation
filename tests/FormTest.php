<?php
require_once __DIR__ . '/bootstrap.php';;

/**
 * @todo: Test processing form input
 * @todo test resetting defaults
 * @todo test setElementValues
 * @todo test reset
 * Enter description here ...
 * @author jon
 *
 */
class FormTest extends TestCase{
  function testDefaultAttributes(){
    $object = new \Foundation\Form();
    
    $this->assertNull($object->getAction());
    $this->assertNull($object->getEnctype());
    $this->assertNull($object->getName());
    
    $this->assertEquals('post', $object->getMethod());
    $this->assertEquals('UTF-8', $object->getAcceptCharset());
    
    $elements = $object->getElements();
    $this->assertTrue(empty($elements));
    
  }
    
  function testSetProperties(){
    $object = new \Foundation\Form();
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
  
  function testNewField(){
    $form = new \Foundation\Form();
    $field = $form->newField();
    $this->assertTrue($field instanceof \Foundation\Form\Field);
    
    $this->assertContains($field, $form->getFields());
  }
  
  function testAddField(){
    $form = new \Foundation\Form();
    $field = new \Foundation\Form\Field($form);
    $form->addField($field);
    $this->assertContains($field, $form->getFields());
  }
  
  function testNewButton(){
    $form = new \Foundation\Form();
    $button = $form->newButton('submit', 'submit');
    $this->assertTrue($button instanceof \Foundation\Form\Element\ButtonInput);
    
    $this->assertContains($button, $form->getElements());
  }
  
  function testHiddenInput(){
    $form = new \Foundation\Form();
    $element = $form->newHiddenElement('hidden', 'hidden');
    $this->assertTrue($element instanceof \Foundation\Form\Element\HiddenInput);
    
    $this->assertContains($element, $form->getElements());
  }
  
  
}