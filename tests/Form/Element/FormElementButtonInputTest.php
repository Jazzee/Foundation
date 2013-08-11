<?php

require_once __DIR__ . '/../../bootstrap.php';
;

class FormElementButtonInputTest extends TestCase
{

    protected $field;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->field = $form->newField();
    }

    function testHidden()
    {
        $object = new \Foundation\Form\Element\ButtonInput($this->field);
        $this->assertEquals('button', $object->getType());
        $object->setType('button');
    }

    function testTypeOverridable()
    {
        $this->setExpectedException('\Foundation\Exception');
        $object = new \Foundation\Form\Element\ButtonInput($this->field);
        $object->setType('text');
    }
}
