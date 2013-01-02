<?php
namespace Foundation;
/**
 * Easier session management
 * 
 * @package Foundation\session
 */
class Session
{
  /**
   * Session configuration data
   * @var array
   */
  protected $config;

  /**
   * Constructor
   * Sensible Configuration Defaults
   */
  public function __construct()
  {
    $this->config = array(
      'name' => null, //name of the session
      'use_only_cookies' => null, //force the use of cookies not passed session ID
      'hash_function' => null, //what hash function to use 0=md5 1=sha1
      'save_path' => null, //where to save the sessions defaults to system default
      'cookie_secure' => null, //force cookies to be sent over ssh only
      'gc_maxlifetime' => null, //how long to wait before garbage collection sessions
      'gc_probability' => null, //how long to wait before garbage collection sessions
      'gc_divisor' => null, //how long to wait before garbage collection sessions
      'cookie_lifetime' => null, //seconds for session timeout
      'cookie_path' => null, //domain path where the cookie will work
      'cookie_domain' => null, //domain where the cookie will work
    );
  }

  /**
   * Delete all the session data and rebuild the containers
   */
  public function restart()
  {
    session_regenerate_id(true);
    $this->setup();
  }

  /**
   * Setup a new session
   */
  public function setup()
  {
    $_SESSION = array();
    $_SESSION['security'] = array(
        'user-agent' => md5(empty($_SERVER['HTTP_USER_AGENT'])?'':$_SERVER['HTTP_USER_AGENT']),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'start' => time()
    );
    $_SESSION['stores'] = array();
  }

  /**
   * Explicity begin a session
   * Sessions are only started when the config is all set.
   */
  public function start()
  {
    session_name($this->getConfigVariable('name'));
    ini_set("session.use_only_cookies", $this->getConfigVariable('use_only_cookies'));
    ini_set("session.cookie_secure", $this->getConfigVariable('cookie_secure'));
    ini_set("session.hash_function", $this->getConfigVariable('hash_function'));
    // create a private session directory so that another script
    // with a lower lifetime doesn't clean up our session
    $path = $this->getConfigVariable('save_path');
    if (
      !empty($path) AND
      is_dir($path) AND
      is_writable($path)
    ) {
      ini_set('session.save_path', $this->getConfigVariable('save_path'));
    }
    //When to destroy sessions on the filesystem
    ini_set('session.gc_maxlifetime', $this->getConfigVariable('gc_maxlifetime'));
    ini_set('session.gc_probability', $this->getConfigVariable('gc_probability'));
    ini_set('session.gc_divisor', $this->getConfigVariable('gc_divisor'));

    //session_set_cookie_params  (lifetime,path,domain,secure)
    session_set_cookie_params($this->getConfigVariable('cookie_lifetime'), $this->getConfigVariable('cookie_path'), $this->getConfigVariable('cookie_domain'), $this->getConfigVariable('cookie_secure'));

    //the session_cache_limiter cache-control line is there to kill a bug in IE that causes the PDF not to be cached over ssl.  
    //these lines allow the caching and let the file be downloaded.  This bug doesn't seem to affect the preview 
    //it was present in IE6 and IE7
    session_cache_limiter('must-revalidate');

    session_start();
    //do a very small check to see if the browser is the same as the originating browser
    //this canbe fooled easily, but provides a bit of security
    if(empty($_SESSION)){
      $this->setup();
    } else if (empty($_SESSION['security']) OR $_SESSION['security']['user-agent'] != md5(empty($_SERVER['HTTP_USER_AGENT'])?'':$_SERVER['HTTP_USER_AGENT'])) {
      $this->restart();
    }
  }

  /**
   * Set configuration variables to override the defaults
   * @param string $name the name of the config option
   * @param mixed $value the value to set
   */
  public function setConfigVariable($name, $value)
  {
    $this->config[$name] = $value;
  }

  /**
   * Retrive confiuration option
   * attempts to find a user set option then loads the default
   * @param string $name the config to load
   */
  public function getConfigVariable($name)
  {
    //if the user has set a config variable return it
    if (array_key_exists($name, $this->config) AND !is_null($this->config[$name])) {
      return $this->config[$name];
    }

    return ini_get('session.' . $name);
  }

  /**
   * Retrieve a session store
   * Gets the store if it exists or created a new one if it doesn't
   * @param string $name
   * @return \Foundation\Session\Store
   */
  public function getStore($name, $lifetime = 0)
  {
    if (array_key_exists($name, $_SESSION['stores'])) {
      $_SESSION['stores'][$name]->setLifetime($lifetime);
      $_SESSION['stores'][$name]->touchActivity();

      return $_SESSION['stores'][$name];
    }
    $_SESSION['stores'][$name] = new Session\Store($lifetime);

    return $_SESSION['stores'][$name];
  }
}