<?php

class FindForeach
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>.*){{\s*foreach\s*\((?<array>[\w|\.]+)\s*as\s*(?<var>\w+)(\s*=>\s*(?<subVar>\w+))?\s*\)\s*}}(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
        return false;
    }
}