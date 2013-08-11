<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormValidatorChoiceInList extends TestCase
{

    public function test()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')->disableOriginalConstructor()->getMock();
        $element = $this->getMockBuilder('\Foundation\Form\Element\ListElement')
                ->disableOriginalConstructor()->getMock();
        $element->expects($this->once())
                ->method('inList')
                ->will($this->returnValue(true));

        $validator = new \Foundation\Form\Validator\ChoiceInList($element);
        $this->assertTrue($validator->validate($input));
    }

    public function testInputArray()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')->disableOriginalConstructor()->getMock();
        $input->expects($this->exactly(2))
                ->method('get')
                ->will($this->returnValue(array(1, 2)));
        $element = $this->getMockBuilder('\Foundation\Form\Element\ListElement')
                ->disableOriginalConstructor()->getMock();
        $element->expects($this->exactly(2))
                ->method('inList')
                ->will($this->returnValue(true));

        $validator = new \Foundation\Form\Validator\ChoiceInList($element);
        $this->assertTrue($validator->validate($input));
    }

    public function testFail()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')->disableOriginalConstructor()->getMock();
        $element = $this->getMockBuilder('\Foundation\Form\Element\ListElement')
                ->disableOriginalConstructor()->getMock();
        $element->expects($this->once())
                ->method('inList')
                ->will($this->returnValue(false));
        $element->expects($this->once())
                ->method('addMessage')
                ->with($this->equalTo('That is not a valid option.'));

        $validator = new \Foundation\Form\Validator\ChoiceInList($element);
        $this->assertFalse($validator->validate($input));
    }

    public function testFailInputArray()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')
                ->disableOriginalConstructor()->getMock();
        $input->expects($this->exactly(2))
                ->method('get')
                ->will($this->returnValue(array(1, 2)));
        $element = $this->getMockBuilder('\Foundation\Form\Element\ListElement')
                ->disableOriginalConstructor()->getMock();
        $element->expects($this->once())
                ->method('inList')
                ->will($this->returnValue(false));
        $element->expects($this->once())
                ->method('addMessage')
                ->with($this->equalTo('That is not a valid option.'));

        $validator = new \Foundation\Form\Validator\ChoiceInList($element);
        $this->assertFalse($validator->validate($input));
    }
}
