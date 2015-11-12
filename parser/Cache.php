<?php

/**
 * Cache file that handles all things related to cache
 * PHP version 5.4
 * @category Caching
 * @package  Templator
 * @author   Ryan Deas <ryandeas1@gmail.com>
 * @license  MIT 2
 * @link     http://supabyte.com/templator
 */

/**
 * Class Cache
 *
 * @category Caching
 * @package  Templator
 * @author   Ryan Deas <ryandeas1@gmail.com>
 * @license  MIT 2
 * @link     http://supabyte.com/templator
 */
class Cache
{
    /**
     * Check to see if the cached version of the file has timed out
     * @param string $template The template file to be loaded
     * @return bool
     */
    public static function cacheTimedOut($template)
    {
        $timestamp = self::getTimestamp($template);
        $modifiedTime = self::getModifiedTime($template);
        if ($timestamp <= $modifiedTime) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the created timestamp from a given cache file
     * @param string $template Name of template file being loaded
     * @return mixed
     */
    public static function getTimestamp($template)
    {
        if (!self::cacheExists($template)) {
            throw new BadFunctionCallException(
                "The cache file you are looking for doesn't exist"
            );
        }
        $html = file_get_contents(__DIR__ . '/../cache/' . $template . '.php');
        preg_match('/<!--\s(?<stamp>\d+)\s-->/', $html, $match);
        return $match['stamp'];
    }

    /**
     * Get the modified time of a given template file
     * @param string $template Name of template file being loaded
     * @return int
     */
    public static function getModifiedTime($template)
    {
        if (Templates::composerTemplate($template) === false) {
            return filemtime(dirname(__DIR__) . '/../templates/' . $template . '.tpl');
        } else {
            return filemtime($_SERVER['DOCUMENT_ROOT'] . '/vendor/' . Templates::$composerFile);
        }
    }

    /**
     * Load the html from a cache file if it exists
     * @param string $template Name of template file being loaded
     * @param array  $vars     Array of variables to be used in the cache file
     * @return void
     */
    public static function loadCacheFile($template, $vars)
    {
        if ($vars === null) {
            $vars = [];
        }
        extract($vars);
        include_once __DIR__ . '/../cache/' . $template . '.php';
    }

    /**
     * Check to see if a cache file exists for the requested template
     * @param string $template Name of template file being loaded
     * @return bool
     */
    public static function cacheExists($template)
    {
        if (file_exists(__DIR__ . '/../cache/' . $template . '.php')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check to make sure that the cache folder actually exists
     * @return bool
     */
    public static function cacheFolderExists()
    {
        return is_dir(__DIR__ . '/../cache');
    }

    /**
     * Create the cache folder if it doesn't already exist
     * @return bool
     */
    public static function createCacheFolder()
    {
        return mkdir(__DIR__ . '/../cache');
    }
}
