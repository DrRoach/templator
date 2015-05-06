<?php

class ParseEndIf
{
    public static function run($line)
    {
        Generate::$inIf = 0;
        return $line['start'] . '<?php endif; ?>' . $line['end'];
    }
}