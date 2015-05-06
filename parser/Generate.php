<?php

class Generate
{
    public static $elseExists   = false;
    public static $inIf         = 0;
    public static $inWhile      = 0;
    public static $inForeach    = 0;
    public static $foreachVar   = null;

    private static $line = 0;

    public static function parse($html, $template)
    {
        $result = '';

        $lines = self::splitLines($html);
        foreach($lines as $line) {
            $result .= self::parseLine($line) ."\n";
        }

        self::storeTemplate($template, $result);

        return self::loadResult($template);
    }

    public static function splitLines($html)
    {
        return explode("\n", $html);
    }

    public static function parseLine($line)
    {
        self::$line++;
        $parsers = self::getParsers();
        foreach($parsers as $parse) {
            $line = self::$parse($line);
        }
        return $line;
    }

    /**
     * Get all parse methods in this class
     * @return array
     */
    public static function getParsers()
    {
        $methods = get_class_methods(__CLASS__);
        $return = [];
        foreach($methods as $m) {
            if(substr($m, 0, 5) != 'parse') {
                continue;
            }
            //Remove both parse and parseLine as they are protected
            if ($m == 'parse' || $m == 'parseLine') {
                continue;
            }
            $return[] = $m;
        }
        return $return;
    }

    public static function parseEcho($line)
    {
        $echo = FindEcho::run($line);
        if(is_array($echo)) {
            $line = ParseEcho::run($echo);
        }

        return $line;
    }

    public static function parseIf($line)
    {
        $echo = FindIf::run($line);
        if(is_array($echo)) {
            self::$inIf = self::$line;
            $line = ParseIf::run($echo);
        }

        return $line;
    }

    public static function parseEndIf($line)
    {
        $echo = FindEndIf::run($line);
        if(is_array($echo)) {
            $line = ParseEndIf::run($echo);
        }

        return $line;
    }

    public static function parseForeach($line)
    {
        $echo = FindForeach::run($line);
        if(is_array($echo)) {
            self::$inForeach = self::$line;
            self::$foreachVar = $echo['array'];
            $line = ParseForeach::run($echo);
        }

        return $line;
    }

    public static function parseEndForeach($line)
    {
        $echo = FindEndForeach::run($line);
        if(is_array($echo)) {
            $line = ParseEndForeach::run($echo);
        }

        return $line;
    }

    public static function parseElse($line)
    {
        $echo = FindElse::run($line);
        if(is_array($echo)) {
            $line = ParseElse::run($echo);
        }

        return $line;
    }

    public static function parseWhile($line)
    {
        $echo = FindWhile::run($line);
        if (is_array($echo)) {
            $line = ParseWhile::run($echo);
        }
        return $line;
    }

    public static function parseEndWhile($line)
    {
        $echo = FindEndWhile::run($line);
        if (is_array($echo)) {
            $line = ParseEndWhile::run($echo);
        }
        return $line;
    }

    public static function parseInclude($line)
    {
        $echo = FindInclude::run($line);
        if (is_array($echo)) {
            $line = ParseInclude::run($echo);
        }
        return $line;
    }

    public static function storeTemplate($template, $result)
    {
        $store = "<!-- " . time() . " -->\n\n\n" . $result;
        file_put_contents(dirname(__DIR__) . '/cache/' . $template . '.php', $store);
    }

    public static function loadResult($template)
    {
        return dirname(__DIR__) . '/cache/' . $template . '.php';
    }

    public static function echoParseExpr($expr)
    {
        return preg_replace('/(?!true)(\b[^0-9\s\(]\w+\b)(?!\w*\()/', '\$$1', $expr);
    }
}
