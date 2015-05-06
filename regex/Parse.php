<?php

class Parse
{
    public static function run($match)
    {
        foreach ($match as $index => $m) {
            if (is_numeric($index)) {
                unset($match[$index]);
            } else {
                if (isset($match[$index][0])) {
                    $match[$index] = $match[$index][0];
                }
            }
        }
        return $match;
    }
}