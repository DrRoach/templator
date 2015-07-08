<?php

class ParseIncrement
{
    public static function run($line)
    {
        if (!empty($line['beforeInc'])) {
            return $line['start'] . '<?php ' . $line['beforeInc'] . '$' . $line['variable'] . '; ?>' . $line['end'];
        } else {
            return $line['start'] . '<?php ' . '$' . $line['variable'] . $line['afterInc'] . '; ?>' . $line['end'];
        }
    }
}