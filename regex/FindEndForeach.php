<?php

class FindEndForeach
{
    public static function run($line)
    {
        if(preg_match('/(?<start>.*){{\s*endforeach;\s*}}(?<end>.*)/', $line, $match)) {
            return Parse::run($match);
        }
        return false;
    }
}