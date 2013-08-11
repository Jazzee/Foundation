<?php

require_once __DIR__ . '/bootstrap.php';

class CacheTest extends TestCase
{

    protected $cache;

    public function setUp()
    {
        $config = new Foundation\Configuration();
        $config->setCacheType('array');
        $this->cache = new \Foundation\Cache(uniqid(), $config);
    }

    public function testCreate()
    {
        $this->assertTrue($this->cache instanceof Foundation\Cache);
    }

    public function testSave()
    {
        $data = uniqid();
        $this->cache->save('testdata', $data);
        $this->assertSame($data, $this->cache->fetch('testdata'));
    }

    public function testContains()
    {
        $data = uniqid();
        $this->cache->save('testdata', $data);
        $this->assertTrue($this->cache->contains('testdata'));
        $this->assertFalse($this->cache->contains('nottestdata'));
    }

    public function testDelete()
    {
        $this->cache->save('testdata', uniqid(), 30);
        $this->cache->save('otherTestData', uniqid(), 30);

        $this->assertTrue($this->cache->contains('testdata'));
        $this->assertTrue($this->cache->contains('otherTestData'));

        $this->assertTrue($this->cache->delete('testdata'));
        $this->assertFalse($this->cache->contains('testdata'));
        $this->assertTrue($this->cache->contains('otherTestData'));
    }

    public function testStats()
    {
        $stats = $this->cache->getStats();
        $this->assertNull($stats);
    }
}
