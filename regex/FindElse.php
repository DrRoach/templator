<?php

class FindElse
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>.*){{\s*else\s*:\s*}}(?<end>.*)/', $line, $match)) {
            return Parse::run($match);
        }
        return false;
    }
}