<?php
require_once __DIR__ . '/bootstrap.php';;

class ConfigurationTest extends TestCase{
  function testCreate(){
    $object = new \Foundation\Configuration();
    $this->assertTrue($object instanceof Foundation\Configuration);
  }
  function testDefaultProperties(){
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
    foreach($properties as $property => $value){
      $method = 'get' . ucfirst($property);
      $this->assertEquals($object->$method(), $value, "Wrong Default for {$property}");
    }
  }
  function testSetCacheType(){
    $object = new \Foundation\Configuration();
    $goodTypes = array('apc', 'array');
    foreach($goodTypes as $type){
      $object->setCacheType($type);
      $this->assertEquals($object->getCacheType(), $type);
    }
  }
  function testInvalidCacheType(){
    $this->setExpectedException('Foundation\Exception');
    $object = new \Foundation\Configuration();
    $object->setCacheType('invalid');
  }
  
  function testSetMailConfig(){
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
    foreach($properties as $property => $value){
      $set = 'set' . ucfirst($property);
      $get = 'get' . ucfirst($property);
      $object->$set($value);
      $this->assertEquals($object->$get(), $value, "Wrong Value for {$property}");
    }
  }
  
}