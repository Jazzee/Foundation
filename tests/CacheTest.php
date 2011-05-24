<?php
require_once __DIR__ . '/bootstrap.php';;

class CacheTest extends TestCase{
  protected $cache;
  
  function setUp(){
    $config = new Foundation\Configuration();
    $config->setCacheType('array');
    $this->cache = new \Foundation\Cache(uniqid(), $config);
  }
  
  function testCreate(){
    $this->assertTrue($this->cache instanceof Foundation\Cache);
  }
  
  function testSave(){
    $data = uniqid();
    $this->cache->save('testdata', $data);
    $this->assertSame($data, $this->cache->fetch('testdata'));
  }
  
  function testContains(){
    $data = uniqid();
    $this->cache->save('testdata', $data);
    $this->assertTrue($this->cache->contains('testdata'));
    $this->assertFalse($this->cache->contains('nottestdata'));
  }
  
  function testDelete(){
    $this->cache->save('testdata', uniqid(), 30);
    $this->cache->save('magicTestData', uniqid(), 30);
    $this->cache->save('prefix_testdata', uniqid(), 30);
    $this->cache->save('testdata_suffix', uniqid(), 30);
    
    $this->assertTrue($this->cache->contains('testdata'));
    $this->assertTrue($this->cache->contains('magicTestData'));
    $this->assertTrue($this->cache->contains('prefix_testdata'));
    $this->assertTrue($this->cache->contains('testdata_suffix'));
    
    $this->cache->deleteByPrefix('prefix_');
    $this->assertTrue($this->cache->contains('testdata'));
    $this->assertFalse($this->cache->contains('prefix_testdata'));
    
    $this->cache->deleteBySuffix('_suffix');
    $this->assertTrue($this->cache->contains('testdata'));
    $this->assertFalse($this->cache->contains('testdata_suffix'));
    
    $this->cache->delete('testdata');
    $this->assertFalse($this->cache->contains('testdata'));
    $this->assertTrue($this->cache->contains('magicTestData'));
    
    $this->cache->delete('ma*');
    $this->assertFalse($this->cache->contains('magicTestData'));
    
  }
}