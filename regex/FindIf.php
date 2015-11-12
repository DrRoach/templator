<?php

class FindIf
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>.*)\s*{{\s*if\s*\((?<statement>.*)\s*\)\s*}}(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
    }

}






