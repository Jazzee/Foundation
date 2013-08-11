<?php

require_once __DIR__ . '/bootstrap.php';
require_once 'CacheTest.php';

class CacheAPCTest extends CacheTest
{

    protected $cache;

    public function setUp()
    {
        if (!(extension_loaded('apc') && ini_get('apc.enabled'))) {
            $this->markTestSkipped('The APC extension is not available.');
        }
        $config = new Foundation\Configuration();
        $config->setCacheType('apc');
        $this->cache = new \Foundation\Cache(uniqid(), $config);
    }

    public function testStats()
    {
        $stats = $this->cache->getStats();
        $this->assertInternalType('array', $stats);
        $this->assertArrayHasKey('hits', $stats);
        $this->assertArrayHasKey('misses', $stats);
        $this->assertArrayHasKey('uptime', $stats);
        $this->assertArrayHasKey('memory_usage', $stats);
        $this->assertArrayHasKey('memory_available', $stats);
    }
}
