<?php

require_once __DIR__ . '/../../bootstrap.php';

class FormValidatorTest extends TestCase
{
    public function test()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')
                ->disableOriginalConstructor()
                ->getMock();
        $element = $this->getMockBuilder('\Foundation\Form\Element')
                ->disableOriginalConstructor()
                ->getMock();
        $validator = $this->getMockForAbstractClass('\Foundation\Form\Validator\AbstractValidator', array($element));
        
        $this->assertTrue($validator->validate($input));
        $this->assertTrue($validator->validateNull($input));
    }
}
