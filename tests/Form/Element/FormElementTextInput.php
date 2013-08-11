<?php

require_once __DIR__ . '/../../bootstrap.php';
;

class FormElementTextInputTest extends TestCase
{

    protected $field;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->field = $form->newField();
    }

    public function testDefaultAttributes()
    {
        $object = new \Foundation\Form\Element\TextInput($this->field);
        $this->assertNull($object->getDisabled());
    }

    public function testSetProperties()
    {
        $object = new \Foundation\Form\Element\TextInput($this->field);
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
