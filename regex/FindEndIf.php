<?php

class FindEndIf
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>.*)(?<statement>{{\s*endif\s*;\s*}})(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
        return false;
    }
}