<?php

class FindEndWhile
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>.*){{\s*endwhile;\s*}}(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
        return false;
    }
}
