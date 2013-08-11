<?php

require_once __DIR__ . '/../bootstrap.php';

class FormFieldTest extends TestCase
{

    public function testDefaultAttributes()
    {
        $form = $this->getMock('\Foundation\Form');
        $field = new \Foundation\Form\Field($form);
        $elements = $field->getElements();
        $this->assertTrue(empty($elements));
        $this->assertNull($field->getInstructions());
        $this->assertNull($field->getLegend());
    }

    public function testSetLegend()
    {
        $text = uniqid();
        $form = $this->getMock('\Foundation\Form');
        $field = new \Foundation\Form\Field($form);
        $field->setInstructions($text);
        $this->assertEquals($text, $field->getInstructions());
        $field->setLegend($text);
        $this->assertEquals($text, $field->getLegend());
    }

    public function testNewElement()
    {
        $form = $this->getMock('\Foundation\Form');
        $form->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array()));
        $field = new \Foundation\Form\Field($form);
        $element = $field->newElement('TextInput', 'test');
        $this->assertContains($element, $field->getElements());
    }

    public function testGetElements()
    {
        $form = $this->getMock('\Foundation\Form');
        $form->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array()));
        $field = new \Foundation\Form\Field($form);
        $elements = array();
        for ($i = 0; $i < 20; $i++) {
            $elements[] = $field->newElement('TextInput', $i);
        }
        foreach ($elements as $element) {
            $this->assertContains($element, $field->getElements());
        }
    }

    public function testBadNewElement()
    {
        $this->setExpectedException('\Foundation\Exception');
        $form = $this->getMock('\Foundation\Form');
        $field = new \Foundation\Form\Field($form);
        $field->newElement('NO_ELEMENT_NAME', 'test');
    }

    public function testAddElement()
    {
        $form = $this->getMock('\Foundation\Form');
        $form->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array()));
        $field = new \Foundation\Form\Field($form);
        $element = new \Foundation\Form\Element\Textarea($field);
        $field->addElement($element);
        $this->assertContains($element, $field->getElements());
    }

    public function testAddElementTwice()
    {
        $name = 'name' . uniqid();
        $stub = $this->getMock('\Foundation\Form\Element');
        $stub->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        $form = $this->getMock('\Foundation\Form');
        $form->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array($name => $stub)));
        $field = new \Foundation\Form\Field($form);
        $message = 'An element with the name ' . $name . ' already exists in this form';
        $this->setExpectedException('\Foundation\Exception', $message);
        $field->addElement($stub);
    }

    public function testGetForm()
    {
        $form = $this->getMock('\Foundation\Form');
        $field = new \Foundation\Form\Field($form);
        $this->assertSame($form, $field->getForm());
    }
}
