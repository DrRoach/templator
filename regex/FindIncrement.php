<?php

class FindIncrement
{
    public static function run($line)
    {
        if (preg_match_all('/(?<start>.*){{\s*(?<beforeInc>\+\+|--)?(?<variable>\w+)(?<afterInc>\+\+|--)?\s*}}(?<end>.*)/', $line, $match)) {
            if (!empty($match['beforeInc'][0]) || !empty($match['afterInc'][0])) {
                return Parse::run($match);
            } else {
                return false;
            }
        }
        return false;
    }
}