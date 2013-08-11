<?php

require_once __DIR__ . '/bootstrap.php';

class FormTest extends TestCase
{

    public function testDefaultAttributes()
    {
        $object = new \Foundation\Form();

        $this->assertNull($object->getAction());
        $this->assertNull($object->getEnctype());
        $this->assertNull($object->getName());

        $this->assertEquals('post', $object->getMethod());
        $this->assertEquals('UTF-8', $object->getAcceptCharset());

        $elements = $object->getElements();
        $this->assertTrue(empty($elements));
    }

    public function testSetProperties()
    {
        $object = new \Foundation\Form();
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

    public function testNewField()
    {
        $form = new \Foundation\Form();
        $field = $form->newField();
        $this->assertTrue($field instanceof \Foundation\Form\Field);

        $this->assertContains($field, $form->getFields());
    }

    public function testAddField()
    {
        $form = new \Foundation\Form();
        $field = new \Foundation\Form\Field($form);
        $form->addField($field);
        $this->assertContains($field, $form->getFields());
    }

    public function testNewButton()
    {
        $form = new \Foundation\Form();
        $button = $form->newButton('submit', 'submit');
        $this->assertTrue($button instanceof \Foundation\Form\Element\ButtonInput);

        $this->assertContains($button, $form->getElements());
    }

    public function testHiddenInput()
    {
        $form = new \Foundation\Form();
        $element = $form->newHiddenElement('hidden', 'hidden');
        $this->assertTrue($element instanceof \Foundation\Form\Element\HiddenInput);

        $this->assertContains($element, $form->getElements());
    }

    public function testCsrfToken()
    {
        $form = new \Foundation\Form();
        $token = 'token' . uniqid();
        $form->setCSRFToken($token);
        $this->assertSame($token, $form->getElementByName('antiCSRFToken')->getValue());

        $token2 = 'token2' . uniqid();
        $form->setCSRFToken($token2);
        $this->assertSame($token2, $form->getElementByName('antiCSRFToken')->getValue());
    }

    public function testMessages()
    {
        $form = new \Foundation\Form();
        $this->assertEmpty($form->getErrorMessages());
        $text = 'Some random message' . uniqid();
        $form->addErrorMessage($text);
        $this->assertTrue(in_array($text, $form->getErrorMessages()));
    }

    public function testProcessInput()
    {
        $form = new \Foundation\Form();
        $this->assertFalse($form->processInput(array()));

        $form->setCSRFToken('testtoken');
        $this->assertFalse($form->processInput(array('test' => null)));

        $form = new \Foundation\Form();
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->once())
                ->method('processInput')
                ->will($this->returnValue(false));
        $field = $this->getMockBuilder('\Foundation\Form\Field')->disableOriginalConstructor()->getMock();
        $field->expects($this->once())
                ->method('getElements')
                ->will($this->returnValue(array('fakename' => $element)));
        $form->addField($field);
        $this->assertFalse($form->processInput(array('test' => null)));

        $form = new \Foundation\Form();
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->once())
                ->method('processInput')
                ->will($this->returnValue(true));
        $field = $this->getMockBuilder('\Foundation\Form\Field')->disableOriginalConstructor()->getMock();
        $field->expects($this->once())
                ->method('getElements')
                ->will($this->returnValue(array('fakename' => $element)));
        $form->addField($field);
        $arr = array('test1' => 'test1' . uniqid(), 'test2' => 'test2' . uniqid());
        $input = $form->processInput($arr);
        $this->assertInstanceOf('\Foundation\Form\Input', $input);
        foreach ($arr as $key => $value) {
            $this->assertSame($value, $input->get($key));
        }
    }

    public function testGetElementByName()
    {
        $form = new \Foundation\Form();
        $name = 'elementName' . uniqid();
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        $field = $this->getMockBuilder('\Foundation\Form\Field')->disableOriginalConstructor()->getMock();
        $field->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array($name => $element)));
        $form->addField($field);
        $this->assertSame($element, $form->getElementByName($name));
        $this->assertFalse($form->getElementByName('test'));
    }

    public function testSetElementValues()
    {
        $form = new \Foundation\Form();
        $name = 'elementName' . uniqid();
        $value = 'newValue' . uniqid();
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        $element->expects($this->once())
                ->method('setValue')
                ->with($value);
        $field = $this->getMockBuilder('\Foundation\Form\Field')->disableOriginalConstructor()->getMock();
        $field->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array($name => $element)));
        $form->addField($field);

        $input = $this->getMockBuilder('\Foundation\Form\Input')->disableOriginalConstructor()->getMock();
        $input->expects($this->once())
                ->method('get')
                ->with($name)
                ->will($this->returnValue($value));
        $form->setElementValues($input);
    }

    public function testApplyDefaultValues()
    {
        $form = new \Foundation\Form();
        $name = 'elementName' . uniqid();
        $value = 'newValue' . uniqid();
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        $element->expects($this->once())
                ->method('getDefaultValue')
                ->will($this->returnValue($value));
        $element->expects($this->once())
                ->method('setValue')
                ->with($value);
        $field = $this->getMockBuilder('\Foundation\Form\Field')->disableOriginalConstructor()->getMock();
        $field->expects($this->any())
                ->method('getElements')
                ->will($this->returnValue(array($name => $element)));
        $form->addField($field);

        $form->applyDefaultValues();
    }

    public function testReset()
    {
        $element = $this->getMock('\Foundation\Form\Element');
        $element->expects($this->any())
                ->method('getName')
                ->will($this->returnCallback('uniqid'));
        $form = new \Foundation\Form();
        $field = $form->newField();
        $field->addElement($element);
        $field->addElement($element);
        $field->addElement($element);
        $form->newField();
        $form->newField();
        $form->newField();
        $this->assertEquals(3, count($form->getElements()));
        $this->assertEquals(6, count($form->getFields()));
        $form->reset();
        $this->assertEquals(2, count($form->getFields()));
        $this->assertEmpty($form->getElements());
    }
}
