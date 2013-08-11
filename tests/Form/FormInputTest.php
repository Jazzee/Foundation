<?php

require_once __DIR__ . '/../bootstrap.php';
;

class FormInputTest extends TestCase
{

    public function test()
    {
        $arr = array();
        for ($i = 1; $i < 5; $i++) {
            $arr[$i] = uniqid();
        }
        $object = new \Foundation\Form\Input($arr);

        foreach ($arr as $key => $value) {
            $this->assertTrue($object->checkIsset($key));
            $this->assertEquals($value, $object->get($key));
            $object->delete($key);
            $this->assertFalse($object->checkIsset($key));
        }
        $this->assertFalse($object->checkIsset(uniqid()));
    }

    public function testEmptyString()
    {
        $arr = array('empty' => '', 'notempty' => uniqid());
        $object = new \Foundation\Form\Input($arr);
        $this->assertNull($object->get('empty'));
        $this->assertEquals($arr['notempty'], $object->get('notempty'));
    }

    public function testMissing()
    {
        $arr = array();
        $object = new \Foundation\Form\Input($arr);
        $this->assertNull($object->get(uniqid()));
    }
}
