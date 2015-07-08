<?php

class FindIncrement
{
    public static function run($line)
    {
        if (preg_match_all('/(?<start>.*){{\s*(?<beforeInc>\+\+|--)?(?<variable>\w+)(?<afterInc>\+\+|--)?\s*}}(?<end>.*)/', $line, $match)) {
            if (!empty($match['beforeInc']) || !empty($match['afterInc'])) {
                return Parse::run($match);
            } else {
                return false;
            }
        }
        return false;
    }
}