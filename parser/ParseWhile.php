<?php

class ParseWhile
{
    public static function run($line)
    {
        $echo = Generate::echoParseExpr($line['expr']);

        return $line['start'] . '<?php while('. $echo . '): ?>' . $line['end'];
    }
}
