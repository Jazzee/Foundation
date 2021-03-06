<?php
namespace Foundation\VC;

/**
 * Config
 * Mostly copied from LightVC - A lightweight view-controller framework.
 * http://lightvc.org/
 *
 * The original framework Copyright (c) 2007, Anthony Bush has been modified to meet the caching and
 * detection needs of our Foundation framework.
 *
 * @package Foundation\vc
 * @see     http://lightvc.org/
 * */
class Config extends \Lvc_Config
{

    /**
     *  Our real cache
     *  @var Cache
     */
    static private $cache;

    /**
     * Temporary Cache
     *
     * WHen a real cache hasn't been sent we put stuff here
     * @var \Foundation\Cache
     */
    static private $tempCache;

    /**
     * Set the cache
     * @param \Foundation\Cache $cache
     */
    public static function setCache($cache)
    {
        self::$cache = $cache;
    }

    /**
     * Get our cache
     * @return \Foundation\Cache;
     */
    protected static function getCache()
    {
        if (is_null(self::$cache)) {
            if (!is_null(self::$tempCache)) {
                return self::$tempCache;
            }
            //no cache was set so we will use our internal array for now.
            //When a cache is set we will update it using this array
            $config = new \Foundation\Configuration;
            $config->setCacheType('array');
            //use a unique id to namespace so we don't have collisions
            self::$tempCache = new \Foundation\Cache(uniqid(), $config);

            return self::$tempCache;
        }

        return self::$cache;
    }

    public static function prefixControllerPath($path)
    {
        array_unshift(self::$controllerPaths, $path);
    }

    public static function prefixControllerViewPath($path)
    {
        array_unshift(self::$controllerViewPaths, $path);
    }

    public static function prefixLayoutViewPath($path)
    {
        array_unshift(self::$layoutViewPaths, $path);
    }

    public static function prefixElementViewPath($path)
    {
        array_unshift(self::$elementViewPaths, $path);
    }

    /**
     * Get the path to a controller include
     * @param string $controllerName
     * @return string path to controller
     */
    public static function getControllerPath($controllerName)
    {
        $cache = self::getCache();
        if ($cachePath = $cache->fetch('Controller' . $controllerName)) {
            return $cachePath;
        }
        foreach (self::$controllerPaths as $path) {
            $file = $path . $controllerName . self::$controllerSuffix;
            if (file_exists($file)) {
                $cache->save('Controller' . $controllerName, $file);

                return $file;
            }
        }
        $cache->save('Controller' . $controllerName, false);
        return false;
    }

    /**
     * Get the path to a view
     * @param string $viewName
     * @param string $viewType (Controller,Element,Layout)
     * @param array $paths
     * @param string $suffix
     * @return string path to view file
     */
    public static function getViewPath($viewName, $viewType, $paths, $suffix)
    {
        $cache = self::getCache();
        if ($cachePath = $cache->fetch($viewType . 'View' . $viewName)) {
            return $cachePath;
        }
        foreach ($paths as $path) {
            $file = $path . $viewName . $suffix;
            if (file_exists($file)) {
                $cache->save($viewType . 'View' . $viewName, $file);

                return $file;
            }
        }
        throw new \Foundation\Exception("Path to View {$viewName} for {$viewType} can not be found");
    }

    /**
     * Include a controller
     * @param string $controlerName
     */
    public static function includeController($controllerName)
    {
        if ($file = self::getControllerPath($controllerName)) {
            include_once($file);
        } else {
            throw new \Foundation\Exception("{$controllerName} does not exist.");
        }
    }

    public static function getController($controllerName)
    {
        if ($file = self::getControllerPath($controllerName)) {
            include_once($file);
            $controllerClass = self::getControllerClassName($controllerName);
            $controller = new $controllerClass();
            $controller->setControllerName($controllerName);

            return $controller;
        }

        return null;
    }

    public static function getControllerView($viewName, &$data = array())
    {
        $file = self::getViewPath($viewName, 'controller', self::$controllerViewPaths, self::$controllerViewSuffix);

        return new self::$viewClassName($file, $data);
    }

    public static function getElementView($elementName, &$data = array())
    {
        $file = self::getViewPath($elementName, 'element', self::$elementViewPaths, self::$elementViewSuffix);

        return new self::$viewClassName($file, $data);
    }

    public static function getLayoutView($layoutName, &$data = array())
    {
        $file = self::getViewPath($layoutName, 'layout', self::$layoutViewPaths, self::$layoutViewSuffix);

        return new self::$viewClassName($file, $data);
    }

    /**
     * See if an element exists
     * @param string $elementName
     */
    public static function elementExists($elementName)
    {
        $cache = self::getCache();
        if ($cachePath = $cache->fetch('Element' . $elementName)) {
            return true;
        }
        foreach (self::$elementViewPaths as $path) {
            $file = $path . $elementName . self::$elementViewSuffix;
            if (file_exists($file)) {
                $cache->save('Element' . $elementName, $file);

                return true;
            }
        }

        return false;
    }

    /**
     * Cascading Element Exists
     * @param string $className
     * @param string $prefix
     * @param string $suffix
     */
    public static function findElementCacading($className, $prefix = '', $suffix = '')
    {
        do {
            //strip namespace information from the class
            $class = \explode('\\', (is_string($className) ? $className : \get_class($className)));
            $class = $class[count($class) - 1];
            $elementName = $prefix . $class . $suffix;
            if (self::elementExists($elementName)) {
                return $elementName;
            }
        } while ($className = get_parent_class($className));

        return false;
    }
}
