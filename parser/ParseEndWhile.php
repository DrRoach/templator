<?php

class ParseEndWhile
{
    public static function run($line)
    {
        return $line['start'] . '<?php endwhile; ?>' . $line['end'];
    }
}
