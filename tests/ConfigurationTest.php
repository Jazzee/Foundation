<?php

require_once __DIR__ . '/bootstrap.php';
;

class ConfigurationTest extends TestCase
{

    public function testCreate()
    {
        $object = new \Foundation\Configuration();
        $this->assertTrue($object instanceof Foundation\Configuration);
    }

    public function testDefaultProperties()
    {
        $object = new \Foundation\Configuration();
        $properties = array(
          'cacheType' => 'array',
          'mailSubjectPrefix' => '',
          'mailDefaultFromAddress' => false,
          'mailDefaultFromName' => false,
          'mailOverrideToAddress' => false,
          'mailOverrideToName' => false,
          'mailServerType' => 'php',
          'mailServerUsername' => false,
          'mailServerPassword' => false,
          'mailServerHost' => false,
          'mailServerPort' => false,
        );
        foreach ($properties as $property => $value) {
            $method = 'get' . ucfirst($property);
            $this->assertEquals($object->$method(), $value, "Wrong Default for {$property}");
        }
    }

    public function testSetCacheType()
    {
        $object = new \Foundation\Configuration();
        $goodTypes = array('apc', 'array');
        foreach ($goodTypes as $type) {
            $object->setCacheType($type);
            $this->assertEquals($object->getCacheType(), $type);
        }
    }

    public function testInvalidCacheType()
    {
        $this->setExpectedException('Foundation\Exception');
        $object = new \Foundation\Configuration();
        $object->setCacheType('invalid');
    }

    public function testSetMailConfig()
    {
        $object = new \Foundation\Configuration();
        $properties = array(
          'mailSubjectPrefix' => uniqid(),
          'mailDefaultFromAddress' => uniqid() . '@example.com',
          'mailDefaultFromName' => uniqid(),
          'mailOverrideToAddress' => uniqid() . '@example.com',
          'mailOverrideToName' => uniqid(),
          'mailServerType' => 'php',
          'mailServerUsername' => uniqid(),
          'mailServerPassword' => uniqid(),
          'mailServerHost' => uniqid(),
          'mailServerPort' => 80,
        );
        foreach ($properties as $property => $value) {
            $set = 'set' . ucfirst($property);
            $get = 'get' . ucfirst($property);
            $object->$set($value);
            $this->assertEquals($object->$get(), $value, "Wrong Value for {$property}");
        }
    }

    public function testSetMailConfigBadFromAddress()
    {
        $object = new \Foundation\Configuration();
        $address = uniqid() . 'bad';
        $this->setExpectedException('\Foundation\Exception', "{$address} is not a valid email address");
        $object->setMailDefaultFromAddress($address);
    }

    public function testSetMailConfigBadToAddress()
    {
        $object = new \Foundation\Configuration();
        $address = uniqid() . 'bad';
        $this->setExpectedException('\Foundation\Exception', "{$address} is not a valid email address");
        $object->setMailOverrideToAddress($address);
    }

    public function testSetMailConfigBadServerType()
    {
        $object = new \Foundation\Configuration();
        $type = 'badtype123';
        $this->setExpectedException('\Foundation\Exception', "{$type} is not a valid Mail Server type");
        $object->setMailServerType($type);
    }

    public function testGetSourcePath()
    {
        $object = new \Foundation\Configuration();
        $path = $object->getSourcePath();
        $this->assertSame(realpath(__DIR__ . '/..'), $path);
    }
}
