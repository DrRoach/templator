<?php

class Templates
{
    public static $composerPackages;
    public static $composerFile;

    /**
     * Check to see if the template file requested is a template added
     * to the project via composer. If so, return it's path
     */
    public static function composerTemplate($file)
    {
        $packages = self::getComposerPackages();
        $template = self::checkPackages($packages, $file);
        self::$composerFile = $template;
        return $template;
    }

    public static function getComposerPackages()
    {
        $return = [];
        $packages = scandir($_SERVER['DOCUMENT_ROOT'] . '/vendor');
        foreach($packages as $key => $package) {
            if(strpos($package, '.') !== false || $package == 'bin' || !is_dir($_SERVER['DOCUMENT_ROOT'] . '/vendor/' . $package)) {
                unset($packages[$key]);
            }
        }
        foreach ($packages as $file) {
            $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/vendor/' . $file);
            foreach ($files as $f) {
                if(strpos($f, '.') === false && is_dir($_SERVER['DOCUMENT_ROOT'] . '/vendor/' . $file . '/' . $f)) {
                    $return[] = $file . '/' . $f;
                }
            }
        }   
        self::$composerPackages = $return;
        return $return;
    }

    public static function checkPackages($packages, $template)
    {
        foreach ($packages as $package) {
            $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/vendor/' . $package);
            foreach ($files as $file) {
                if ($file == $template . '.tpl') {
                    return $package . '/' . $file;
                }
            }
        }
        return false;
    }
}
