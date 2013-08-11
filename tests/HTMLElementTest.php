<?php

require_once __DIR__ . '/bootstrap.php';
;

class HTMLElementTest extends TestCase
{

    public function testDefaultAttributes()
    {
        $object = new \Foundation\HTMLElement();
        foreach ($object->getAttributes() as $memberName => $htmlName) {
            $method = 'get' . ucfirst($memberName);
            $this->assertNull($object->$method(), "Wrong Default for {$memberName}");
        }
        $class = $object->getClass();
        $this->assertTrue(empty($class));
    }

    public function testSetProperties()
    {
        $object = new \Foundation\HTMLElement();
        $value = uniqid();
        foreach ($object->getAttributes() as $memberName => $htmlName) {
            $set = 'set' . ucfirst($memberName);
            $object->$set($value);
        }
        foreach ($object->getAttributes() as $memberName => $htmlName) {
            $get = 'get' . ucfirst($memberName);
            $this->assertEquals($value, $object->$get(), "Wrong value for {$memberName}");
        }

        $object->addClass($value);
        $this->assertEquals($value . ' ' . $value, $object->getClass());

        $object->setClass('');
        $this->assertEmpty($object->getClass());

        $object->setClass("{$value},{$value},{$value}");
        $this->assertEquals($value . ' ' . $value . ' ' . $value, $object->getClass());

        $object->setClass("{$value}, {$value} ,    {$value} ");
        $this->assertEquals($value . ' ' . $value . ' ' . $value, $object->getClass());
    }
}
