<?php

class ParseIf
{
    public static function run($line)
    {
        //Create variables
        $echo = Generate::echoParseExpr($line['statement']);

        return $line['start'] . '<?php if('. $echo . '): ?>' . $line['end'];
    }
}