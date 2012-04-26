<?php
namespace Foundation;
/**
 * A pluggable cache
 * Fascade for Doctrine\Common\Cache drivers to work
 * 
 * @package Foundation
 */
class Cache implements \Doctrine\Common\Cache\Cache
{
  protected $cache;
  protected $config;

  /**
   * Setup the cache based on the configuration we are using
   * @param string $namespace unique caching namespace
   * @param Configuration $config
   */
  public function __construct($namespace, Configuration $config)
  {
    $this->config = $config;
    switch($this->config->getCacheType()){
      case 'array':
        $this->cache = new \Doctrine\Common\Cache\ArrayCache;
          break;
      case 'apc':
        $this->cache = new \Doctrine\Common\Cache\ApcCache;
          break;
    }
    $this->cache->setNameSpace($namespace);
  }

  /**
   * Fetch an item from the cache
   * @param string $id
   * @return mixed the cached data or FALSE if no data exists
   */
  public function fetch($id)
  {
    return $this->cache->fetch($id);
  }

  /**
   * Check if an item is in the cache
   * @param string $id
   * @return true if item exists | false if not
   */
  public function contains($id)
  {
    return $this->cache->contains($id);
  }

  /**
   * Save data in the cache
   * @param string $id
   * @param mixed $data
   * @param $integer $lifeTime
   */
  public function save($id, $data, $lifeTime = 0)
  {
    $this->cache->save($id, $data, $lifeTime);
  }

  /**
   * Delete item from the cache
   * @param string $id
   */
  public function delete($id)
  {
    $this->cache->delete($id);
  }

  /**
   * Get all our cached ids
   * 
   * @return array $ids
   */
  public function getIds()
  {
    return $this->cache->getIds();
  }

  /**
   * Pass through to cache provider 
   */
  public function getStats()
  {
    return $this->cache->getStats();
  }
}