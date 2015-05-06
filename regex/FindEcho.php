<?php

class FindEcho
{
    public static function run($line)
    {
        if(preg_match_all('/(?<start>[^\{]*)\s*{{(?<startQuickEsc>{)?\s*(?<echo>\w+(\.\w+)*)(?<escape>[\|!](e|escape))?\s*}}(?<endQuickEsc>})?(?<end>.*)/', $line, $match)) {
            return Parse::run($match);
        }

        return false;
    }
}
