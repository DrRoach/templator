<?php
class FindInclude
{
    public static function run($line)
    {
        if (preg_match_all('/(?<start>.*)?{{\s*include\((?<file>[\w.\/]+)\)\s*}}(?<end>.*)/', $line, $matches)) {
            return Parse::run($matches);
        }
        return false;
    }
}
