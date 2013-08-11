<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormElementInputTest extends TestCase
{

    protected $field;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->field = $form->newField();
    }

    public function testDefaultAttributes()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\Input', array($this->field));
        $this->assertNull($object->getDisabled());
        $this->assertEquals('text', $object->getType());
        $this->assertNull($object->getMaxLength());
    }

    public function testSetProperties()
    {
        $object = $this->getMockForAbstractClass('\Foundation\Form\Element\Input', array($this->field));
        $value = uniqid();
        foreach ($object->getAttributes() as $memberName => $htmlName) {
            $set = 'set' . ucfirst($memberName);
            $object->$set($value);
        }
        foreach ($object->getAttributes() as $memberName => $htmlName) {
            $get = 'get' . ucfirst($memberName);
            $this->assertEquals($value, $object->$get(), "Wrong value for {$memberName}");
        }
    }
}
