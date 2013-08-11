<?php
require_once __DIR__ . '/../../bootstrap.php';

class FormElementListElementTest extends TestCase
{

    protected $field;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->field = $form->newField();
    }

    function testNewItem()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        $item = $object->newItem('value', 'label');
        $this->assertContains($item, $object->getItems());
    }

    function testAddItem()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        $item = new \Foundation\Form\Element\ListItem();
        $item->setValue('value');
        $item->setLabel('label');
        $object->addItem($item);
        $this->assertContains($item, $object->getItems());
    }

    function testGetLabelForValue()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        for ($i = 0; $i < 10; $i++) {
            $item = new \Foundation\Form\Element\ListItem();
            $item->setValue($i . 'value');
            $item->setLabel($i . 'label');
            $object->addItem($item);
        }
        for ($i = 0; $i < 10; $i++) {
            $this->assertEquals($i . 'label', $object->getLabelForValue($i . 'value'));
        }
        $this->assertFalse($object->getLabelForValue('testnothing' . uniqid()));
    }

    public function testAddItemTwice()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        $item = new \Foundation\Form\Element\ListItem();
        $item->setValue('value');
        $item->setLabel('label');
        $object->addItem($item);
        
        $this->setExpectedException('\Foundation\Exception', $item->getValue() . ' is already an item in this list');
        $item2 = new \Foundation\Form\Element\ListItem();
        $item2->setValue('value');
        $item2->setLabel('label');
        $object->addItem($item2);
    }

    function testInList()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        for ($i = 0; $i < 3; $i++) {
            $item = new \Foundation\Form\Element\ListItem();
            $item->setValue($i . 'value');
            $item->setLabel($i . 'label');
            $object->addItem($item);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($object->inList($i . 'value'));
        }
        $this->assertFalse($object->inList('testnothing' . uniqid()));
    }

    public function testToArray()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\ListElement', array($this->field));
        for ($i = 0; $i < 3; $i++) {
            $item = new \Foundation\Form\Element\ListItem();
            $item->setValue($i . 'value');
            $item->setLabel($i . 'label');
            $object->addItem($item);
        }
        $values = array(
          'name' => 'test' . uniqid(),
          'class' => 'test' . uniqid(),
          'value' => 'test' . uniqid(),
          'instructions' => 'test' . uniqid(),
          'format' => 'test' . uniqid(),
          'label' => 'test' . uniqid()
        );
        $object->setName($values['name']);
        $object->setValue($values['value']);
        $object->setClass($values['class']);
        $object->setInstructions($values['instructions']);
        $object->setFormat($values['format']);
        $object->setLabel($values['label']);

        $arr = $object->toArray();
        $this->assertArrayHasKey('items', $arr);
        for ($i = 0; $i < 3; $i++) {
            $this->assertArrayHasKey($i, $arr['items']);
            $this->assertSame($i . 'label', $arr['items'][$i]['label']);
            $this->assertSame($i . 'value', $arr['items'][$i]['value']);
        }
        unset($arr['items']);
        foreach ($arr as $key => $value) {
            $this->assertArrayHasKey($key, $values);
            $this->assertSame($values[$key], $value);
        }
    }
}
