<?php
namespace Foundation\Session;

/**
 * Session Store
 * Seperate Session stores allow the same variables to be sepearted
 * For instance a user can be logged in to two seperate parts of an application
 * 
 * @package Foundation\session
 */
class Store
{

    /**
     * Data Store
     * @var array
     */
    protected $data;

    /**
     * The last time activitity was recorded for this store
     * @var int
     */
    protected $lastActivity;

    /**
     * The last time the user was authenticated
     * @var int
     */
    protected $lastAuthentication;

    /**
     * Lifetime
     * @var int
     */
    protected $lifetime;

    /**
     * Constructor
     * Set Some Defaults
     */
    public function __construct($lifetime)
    {
        $this->data = array();
        $this->lastAuthentication = 0;
        $this->lifetime = $lifetime;
        $this->lastActivity = time(); //dont use touchActivity() causes an infinate loop if store is expired
    }

    /**
     * Expire the store
     */
    public function expire()
    {
        $this->__construct($this->lifetime);
    }

    /**
     * Check to see if the data should be expired
     * If so then destroy the store
     */
    protected function checkExpired()
    {
        if ($this->lifetime and (time() - $this->lastActivity) > $this->lifetime) {
            $this->expire();
        }
    }

    /**
     * Set the lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * Update the lastActivity timestamp
     */
    public function touchActivity()
    {
        $this->checkExpired();
        $this->lastActivity = time();
    }

    /**
     * Update the lastAuthentication timestamp
     * Logging in regenerates the id which is a best practice
     */
    public function touchAuthentication()
    {
        session_regenerate_id();
        $this->lastAuthentication = time();
    }

    /**
     * Store data in the session
     * @param string $name the name of the data
     * @param mixed $value the value to store
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Retrieve data stored in the session
     * @param string $name the name of the data
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Store data in the session
     * @param string $name the name of the data
     * @param mixed $value the value to store
     */
    public function set($name, $value)
    {
        $this->touchActivity();
        $this->data[$name] = $value;
    }

    /**
     * Retrieve data stored in the session
     * @param string $name the name of the data
     */
    public function get($name)
    {
        $this->touchActivity();
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        throw new \Foundation\Exception("{$name} does not exist in this session store");
    }

    /**
     * Check if a property is set
     * @param string $name
     */
    public function __isset($name)
    {
        return $this->check($name);
    }

    /**
     * Unset a property
     * @param string $name
     */
    public function __unset($name)
    {
        $this->remove($name);
    }

    /**
     * Check if a property is set
     * @param string $name
     */
    public function check($name)
    {
        $this->touchActivity();

        return isset($this->data[$name]);
    }

    /**
     * Unset a property
     * @param string $name
     */
    public function remove($name)
    {
        $this->touchActivity();
        unset($this->data[$name]);
    }
}
