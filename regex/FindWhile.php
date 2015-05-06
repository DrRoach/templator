<?php

class FindWhile
{
    public static function run($line)
    {
        if (preg_match_all('/(?<start>.*){{\s*while\((?<expr>.*)\)\s*}}(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
        return false;
    }
}
