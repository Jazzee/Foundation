<?php

require_once __DIR__ . '/../../bootstrap.php';
;

class FormElementTest extends TestCase
{

    /**
     *
     * @var \Foundation\Form\Element
     */
    protected $element;

    public function setUp()
    {
        $form = new \Foundation\Form();
        $this->element = new \Foundation\Form\Element\TextInput($form->newField());
    }

    public function testMessages()
    {
        $this->assertEmpty($this->element->getMessages());
        $text = 'Some random message' . uniqid();
        $this->element->addMessage($text);
        $this->assertTrue(in_array($text, $this->element->getMessages()));
    }

    public function testValidators()
    {
        $this->assertEmpty($this->element->listValidators());
        $validator1 = $this->getMock('\Foundation\Form\Validator');
        $validator2 = $this->getMock('\Foundation\Form\Validator');
        $validator3 = $this->getMock('\Foundation\Form\Validator');
        $this->assertNotSame($validator3, $validator2);
        $this->element->addValidator($validator2);
        $this->element->addValidator($validator3);
        $this->element->prependValidator($validator1);
        $validators = $this->element->listValidators();
        $this->assertArrayHasKey(0, $validators);
        $this->assertArrayHasKey(1, $validators);
        $this->assertArrayHasKey(2, $validators);
        $this->assertSame($validator1, $validators[0]);
        $this->assertSame($validator2, $validators[1]);
        $this->assertSame($validator3, $validators[2]);
    }

    public function testFilters()
    {
        $this->assertEmpty($this->element->listFilters());
        $filter1 = $this->getMock('\Foundation\Form\Filter');
        $filter2 = $this->getMock('\Foundation\Form\Filter');
        $filter3 = $this->getMock('\Foundation\Form\Filter');
        $this->assertNotSame($filter2, $filter3);
        $this->element->addFilter($filter2);
        $this->element->addFilter($filter3);
        $this->element->prependFilter($filter1);
        $filters = $this->element->listFilters();
        $this->assertArrayHasKey(0, $filters);
        $this->assertArrayHasKey(1, $filters);
        $this->assertArrayHasKey(2, $filters);
        $this->assertSame($filter1, $filters[0]);
        $this->assertSame($filter2, $filters[1]);
        $this->assertSame($filter3, $filters[2]);
    }

    public function testPreRender()
    {

        $validator = $this->getMockForAbstractClass('\Foundation\Form\Validator', array('preRender'));
        $validator->expects($this->once())->method('preRender');
        $this->element->addValidator($validator);

        $this->assertNotContains('error', $this->element->getClass());
        $this->element->addMessage('test');
        $this->element->preRender();
        $this->assertContains('error', $this->element->getClass());
    }

    public function testProcessInputGood()
    {
        $testValue = 'som value' . uniqid();
        $input = $this->getMockBuilder('\Foundation\Form\Input')
                ->disableOriginalConstructor()
                ->getMock();
        $input->expects($this->any())
                ->method('get')
                ->will($this->returnValue($testValue));
        $input->expects($this->once())
                ->method('set')
                ->with($this->equalTo($this->element->getName()), $this->equalTo($testValue));

        $validator = $this->getMockForAbstractClass('\Foundation\Form\Validator');
        $validator->expects($this->once())
                ->method('validate')
                ->will($this->returnValue(true));
        $this->element->addValidator($validator);

        $filter = $this->getMockForAbstractClass('\Foundation\Form\Filter');
        $filter->expects($this->once())
                ->method('filterValue')
                ->with($this->equalTo($testValue))
                ->will($this->returnArgument(0));
        $this->element->addFilter($filter);

        $this->assertTrue($this->element->processInput($input));
    }

    public function testProcessInputBad()
    {
        $input = $this->getMockBuilder('\Foundation\Form\Input')
                ->disableOriginalConstructor()
                ->getMock();
        $input->expects($this->any())
                ->method('get')
                ->will($this->returnValue('some value'));
        $validator = $this->getMockForAbstractClass('\Foundation\Form\Validator');
        $validator->expects($this->once())
                ->method('validate')
                ->will($this->returnValue(false));
        $this->element->addValidator($validator);

        $this->assertFalse($this->element->processInput($input));
    }

    public function testGetField()
    {
        $form = new \Foundation\Form();
        $field = $form->newField();
        $element = new \Foundation\Form\Element\TextInput($field);
        $this->assertSame($field, $element->getField());
    }

    public function testDefaultValue()
    {
        $value = 'test' . uniqid();
        $this->element->setDefaultValue($value);
        $this->assertSame($value, $this->element->getDefaultValue());
    }

    public function testInstructions()
    {
        $value = 'test' . uniqid();
        $this->element->setInstructions($value);
        $this->assertSame($value, $this->element->getInstructions());
    }

    public function testFormat()
    {
        $value = 'test' . uniqid();
        $this->element->setFormat($value);
        $this->assertSame($value, $this->element->getFormat());
    }

    public function testToArray()
    {
        $values = array(
          'name' => 'test' . uniqid(),
          'class' => 'test' . uniqid(),
          'value' => 'test' . uniqid(),
          'instructions' => 'test' . uniqid(),
          'format' => 'test' . uniqid(),
          'label' => 'test' . uniqid()
        );
        $this->element->setName($values['name']);
        $this->element->setValue($values['value']);
        $this->element->setClass($values['class']);
        $this->element->setInstructions($values['instructions']);
        $this->element->setFormat($values['format']);
        $this->element->setLabel($values['label']);

        $arr = $this->element->toArray();
        foreach ($arr as $key => $value) {
            $this->assertArrayHasKey($key, $arr);
            $this->assertSame($values[$key], $value);
        }
    }
}
