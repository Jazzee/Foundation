<?php
namespace Foundation;

/**
 * Configuration
 * Define all the necessary defaults for foundation
 * This class has to be passed to most foundation classes
 * 
 * @package Foundation
 */
class Configuration
{

    /**
     * The cache type
     * @var string
     */
    protected $cacheType;

    /**
     * The Mail Subject Prefix
     * @var string
     */
    protected $subjectPrefix;

    /**
     * The default from address
     * @var string
     */
    protected $defaultFromAddress;

    /**
     * The default from name
     * @var string
     */
    protected $defaultFromName;

    /**
     * The override to address
     * @var string
     */
    protected $overrideToAddress;

    /**
     * The override to name
     * @var string
     */
    protected $overrideToName;

    /**
     * Mail server type
     * @var string
     */
    protected $mailServerType;

    /**
     * Mail server host
     * @var string
     */
    protected $mailServerHost;

    /**
     * Mail server Port
     * @var string
     */
    protected $mailServerPort;

    /**
     * Mail server username
     * @var string
     */
    protected $mailServerUser;

    /**
     * Mail server password
     * @var string
     */
    protected $mailServerPass;

    /**
     * Set Sensible defaults
     */
    public function __construct()
    {
        $this->setCacheType('array');
        $this->setMailSubjectPrefix('');
        $this->setMailDefaultFromAddress(false);
        $this->setMailDefaultFromName(false);
        $this->setMailOverrideToAddress(false);
        $this->setMailOverrideToName(false);
        $this->setMailServerType('php');
        $this->setMailServerHost(false);
        $this->setMailServerPort(false);
        $this->setMailServerUsername(false);
        $this->setMailServerPassword(false);
    }

    /**
     * Set the cache type
     * @param string $type
     */
    public function setCacheType($type)
    {
        if (!in_array($type, array('array', 'apc'))) {
            throw new Exception("{$type} is not a valid cache type");
        }
        $this->cacheType = $type;
    }

    /**
     * Get the cache type
     * @return string array|apc|memcache
     */
    public function getCacheType()
    {
        return $this->cacheType;
    }

    /**
     * Set the subject prefix
     * @param string $prefix
     */
    public function setMailSubjectPrefix($prefix)
    {
        $this->subjectPrefix = $prefix;
    }

    /**
     * Get the subject prefix
     * @return string
     */
    public function getMailSubjectPrefix()
    {

        return $this->subjectPrefix;
    }

    /**
     * Set the default from address
     * @param string $address
     */
    public function setMailDefaultFromAddress($address)
    {
        if ($address and !\filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("{$address} is not a valid email address");
        }
        $this->defaultFromAddress = $address;
    }

    /**
     * Get the default from address
     * @return string
     */
    public function getMailDefaultFromAddress()
    {

        return $this->defaultFromAddress;
    }

    /**
     * Set the default from name
     * @param string $name
     */
    public function setMailDefaultFromName($name)
    {
        $this->defaultFromName = $name;
    }

    /**
     * Get the default from name
     * @return string
     */
    public function getMailDefaultFromName()
    {
        return $this->defaultFromName;
    }

    /**
     * Set the overrideTo address
     * @param string $address
     */
    public function setMailOverrideToAddress($address)
    {
        if ($address and !\filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("{$address} is not a valid email address");
        }
        $this->overrideToAddress = $address;
    }

    /**
     * Get the overrideto address
     * @return string
     */
    public function getMailOverrideToAddress()
    {
        return $this->overrideToAddress;
    }

    /**
     * Set the override to name
     * @param string $name
     */
    public function setMailOverrideToName($name)
    {
        $this->overrideToName = $name;
    }

    /**
     * Get the override to name
     * @return string
     */
    public function getMailOverrideToName()
    {
        return $this->overrideToName;
    }

    /**
     * Set the mail server type
     * @param string $type
     */
    public function setMailServerType($type)
    {
        if (!in_array($type, array('php', 'sendmail', 'smtp', 'smtp+ssl'))) {
            throw new Exception("{$type} is not a valid Mail Server type");
        }
        $this->mailServerType = $type;
    }

    /**
     * Get the Mail Server Type
     * @return string
     */
    public function getMailServerType()
    {
        return $this->mailServerType;
    }

    /**
     * Set the mail server host
     * @param string $host
     */
    public function setMailServerHost($host)
    {
        $this->mailServerHost = $host;
    }

    /**
     * Get the Mail Server Type
     * @return string
     */
    public function getMailServerHost()
    {
        return $this->mailServerHost;
    }

    /**
     * Set the mail server port
     * @param string $port
     */
    public function setMailServerPort($port)
    {
        $this->mailServerPort = $port;
    }

    /**
     * Get the Mail Server Type
     * @return string
     */
    public function getMailServerPort()
    {
        return $this->mailServerPort;
    }

    /**
     * Set the mail server username
     * @param string $username
     */
    public function setMailServerUsername($username)
    {
        $this->mailServerUser = $username;
    }

    /**
     * Get the Mail Server Type
     * @return string
     */
    public function getMailServerUsername()
    {
        return $this->mailServerUser;
    }

    /**
     * Set the mail server password
     * @param string $password
     */
    public function setMailServerPassword($password)
    {
        $this->mailServerPass = $password;
    }

    /**
     * Get the Mail Server Type
     * @return string
     */
    public function getMailServerPassword()
    {
        return $this->mailServerPass;
    }

    /**
     * Get the path to the foundation source
     * @return string
     */
    public static function getSourcePath()
    {
        return realpath(__DIR__ . '/../..');
    }
}
