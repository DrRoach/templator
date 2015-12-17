<?php

/**
 * This is the first file that is called and used to load the whole template
 * PHP version 5.4
 * @category Generate
 * @package  Templator
 * @author   Ryan Deas <ryandeas1@gmail.com>
 * @license  MIT 2
 * @link     http://supabyte.com/templator
 */

/**
 * Class Templator
 *
 * PHP version 5.4
 *
 * @category Generating
 * @package  Templator
 * @author   Ryan Deas <ryandeas1@gmail.com>
 * @license  MIT 2
 * @version  Release: v1.2.2
 * @link     http://supabyte.com/templator
 */
class Templator
{
    /**
     * To be used in places such as ParseInclude to pass given parameters
     * down to sub Templator::load() calls
     */
    public static $definedVars = [];
    public static $templateLocation = "";

    /**
     * First function called to begin loading template
     * @param string  $template The template file to be loaded
     * @param array   $vars     Array of variables to be used in template
     * @param boolean $ajax     If true then echo the rendered template
     * @throws Exception
     * @return void
     */
    public static function load($template, $vars, $ajax = false)
    {
        //Get the location of the templates folder
        $setup['templates'] = file_get_contents(__DIR__ . '/setup.json');
        $setup['templates'] = json_decode($setup['templates']);
        $setup['templates'] = $setup['templates']->templates;
        $dir = explode('/', __DIR__);
        if ($dir[sizeof($dir)-1] == "templator" && $dir[sizeof($dir)-2] == "drroach" && $dir[sizeof($dir)-3] == "vendor") {
            self::$templateLocation = dirname(dirname(dirname(__DIR__))) . $setup['templates'] . 'templates/' . $template . '.tpl';
        } else {
            self::$templateLocation = dirname(__DIR__) . '/templates/' . $template . '.tpl';

        }
        
        self::$definedVars = $vars;
        //Check to see if a cached file already exists
        if (Cache::cacheExists($template)) {
            $timedOut = Cache::cacheTimedOut($template);
            if (!$timedOut) {
                Cache::loadCacheFile($template, $vars);
                return;
            }
        }
        self::checkTemplateExists($template);
        $templateHtml = self::getTemplateHtml($template);
        if ($vars === null) {
            $vars = [];
        }
        extract($vars);
        include Generate::parse($templateHtml, $template);
    }

    public static function populateJs($vars)
    {
        echo '<script>'
            . 'Templator.data = ' . json_encode($vars) . ';'
            . '</script>';
        return true;
    }

    /**
     * Check to make sure that the requested template file exists
     * @param string $template Name of template file being loaded
     * @throws Exception
     * @return void
     */
    public static function checkTemplateExists($template)
    {
        if (!file_exists(self::$templateLocation)) {
            //Check to see if the template is a composer file
            if (Templates::composerTemplate($template) === false) {
                throw new Exception("The template '$template' doesn't exist");
            }
        }
    }

    /**
     * Get the contents of the template file being used
     * @param string $template Name of template file being loaded
     * @return string
     */
    public static function getTemplateHtml($template)
    {
        if (!Templates::$composerFile) {
            return file_get_contents(self::$templateLocation);
        } else {
            return file_get_contents(dirname(__DIR__) . '/vendor/' . Templates::$composerFile);
        }
    }
}

/**
 * Autoload function
 * @param  string $class Class file to be autoloaded
 * @return void
 */
function __autoload($class)
{
    if (file_exists(__DIR__ . '/' . $class . '.php')) {
        include_once __DIR__ . '/' . $class . '.php';
    } else if (file_exists(__DIR__ . '/' . 'parser/' . $class . '.php')) {
        include_once __DIR__ . '/' . 'parser/' . $class . '.php';
    } else if (file_exists(__DIR__ . '/' . 'regex/' . $class . '.php')) {
        include_once __DIR__ . '/' . 'regex/' . $class . '.php';
    }
}

spl_autoload_register('__autoload');
