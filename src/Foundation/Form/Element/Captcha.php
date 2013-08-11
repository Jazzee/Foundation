<?php
namespace Foundation\Form\Element;

/**
 * A CAPTCHA Element to validate against bots
 * uses reCAPTCHA library from http://recaptcha.net/
 * 
 * @package Foundation\form\element
 */
class Captcha extends AbstractElement
{
    /**
     * The reCAPTCHA server URL's
     */

    const API_SERVER = 'http://www.google.com/recaptcha/api';
    const API_SECURE_SERVER = 'https://www.google.com/recaptcha/api';
    const SIGNUP_SERVER = 'https://www.google.com/recaptcha/admin/create';

    /**
     * Our Private API Key
     * @var string
     */
    static private $privateApiKey;

    /**
     * Our Public API Key
     * @var string
     */
    static private $publicApiKey;

    /**
     * Local copy of public api key
     * @var string
     */
    protected $publicKey;

    /**
     * The server we are connecting to
     * @var string
     */
    protected $server;

    /**
     * Holds the error message from processing
     * @var string
     */
    public $errorString = '';

    /**
     * What reCaptcha theme should we use
     * @var string
     */
    protected $themeName = 'red';

    /**
     * Constructor
     * Check the API keys
     */
    public function __construct($field)
    {
        if (!self::$privateApiKey) {
            throw new \Foundation\Exception('Private API Key not set for reCAPTCHA library.');
        }
        if (!self::$publicApiKey) {
            throw new \Foundation\Exception('Public API Key not set for reCAPTCHA library.');
        }

        //move the static keys into local space for ease of use
        $this->publicKey = self::$publicApiKey;

        //use the secure server
        $this->server = self::API_SECURE_SERVER;

        parent::__construct($field);

        $this->addValidator(new \Foundation\Form\Validator\Captcha($this, self::$privateApiKey));
    }

    /**
     * Set the api keys
     * @param string $private
     * @param string $public
     */
    public static function setKeys($private, $public)
    {
        self::$privateApiKey = $private;
        self::$publicApiKey = $public;
    }

    /**
     * gets a URL where the user can sign up for reCAPTCHA.
     * @param string $domain The domain where the page is hosted
     * @param string $appname The name of your application
     */
    public static function signupUrl($domain = null, $appname = null)
    {
        $url = self::SIGNUP_SERVER;
        if ($domain) {
            $url .= '?domain=' . \urlencode($domain);
            if ($appname) {
                $url .= '&app=' . \urlencode($appname);
            }
        }

        return $url;
    }

    /**
     * Set the theme
     * @param string $themeName
     */
    public function setTheme($themeName)
    {
        //valid themes
        $arr = array('red', 'white', 'blackglass', 'clean', 'custom');
        if (!\in_array($themeName, $arr)) {
            throw \Foundation\Exception('Invalid reCaptch theme');
        }
        $this->themeName = $themeName;
    }

    /**
     * Get the theme
     * @return string the current theme
     */
    public function getTheme()
    {
        return $this->themeName;
    }

    /**
     * Get the server
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get the public key
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}
