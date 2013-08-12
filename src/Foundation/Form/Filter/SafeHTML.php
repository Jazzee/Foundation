<?php
namespace Foundation\Form\Filter;

/**
 * Make sure input is safe
 * Uses HTML Purifier
 * 
 * @package Foundation\form\filter
 */
class SafeHTML extends AbstractFilter
{

    /**
     * Where to store the cache files
     * @var string
     */
    static private $cachePath;

    /**
     * Check to be sure we have the HTML purifier library
     * @param \Foundation\Form\Element $e
     * @param mixed $ruleSet 
     */
    public function __construct(\Foundation\Form\Element $e, $ruleSet = null)
    {
        parent::__construct($e, $ruleSet);
        if (!class_exists('HTMLPurifier')) {
            throw new \Foundation\Exception('HTML Purifier is required for the SafeHTML filter and it is not included');
        }
    }

    /**
     * Set the cache path
     * @param string $cachePath
     */
    public static function setCachePath($cachePath)
    {
        $cachePath = realpath($cachePath);
        if (!is_writable($cachePath)) {
            throw new \Foundation\Exception("{$cachePath} is not writable and cannot be the HTMLPurifier cache path.");
        }

        $cachePath = $cachePath . '/htmlpurifiercache';
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        self::$cachePath = $cachePath;
    }

    public function filterValue($value)
    {
        //call the bootstrap class so that we get the constant definitions
        $bsBootstrap = new \HTMLPurifier_Bootstrap();
        // set up configuration
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', 'JazzeeFoundationFormFilterSafeHTML');
        $config->set('HTML.DefinitionRev', 1); // increment when configuration changes
        $config->set("Core.AggressivelyFixLt", true);
        $config->set("Core.EscapeInvalidTags", true);
        $config->set("Core.EscapeInvalidChildren", true);
        // Doctype
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        if (!is_null(self::$cachePath)) {
            $config->set('Cache.SerializerPath', self::$cachePath);
        }

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($value);
    }
}
