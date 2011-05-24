<?php
require_once __DIR__ . '/../../bootstrap.php';;
class TestFormElementListElement extends \Foundation\Form\Element\ListElement{
  
}

class FormElementListElementTest extends TestCase{
  protected $field;
  
  public function setUp(){
    $form = new \Foundation\Form();
    $this->field = $form->newField();
  }
  function testNewItem(){
    $object = new TestFormElementListElement($this->field);
    $item = $object->newItem('value', 'label');
    $this->assertContains($item, $object->getItems());
  }
  
  function testAddItem(){
    $object = new TestFormElementListElement($this->field);
    $item = new \Foundation\Form\Element\ListItem();
    $item->setValue('value');
    $item->setLabel('label');
    $object->addItem($item);
    $this->assertContains($item, $object->getItems());
  }
  
function testGetLabelForValue(){
    $object = new TestFormElementListElement($this->field);
    for($i=0;$i<10;$i++){
      $item = new \Foundation\Form\Element\ListItem();
      $item->setValue($i.'value');
      $item->setLabel($i.'label');
      $object->addItem($item);
    }
    for($i=0;$i<10;$i++){
      $this->assertEquals($i.'label', $object->getLabelForValue($i.'value'));
    }
  }
}