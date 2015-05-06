<?php

class ParseInclude
{
    public static function run($line)
    {
        return $line['start'] . '<?php Templator::load("'.$line['file'].'", Templator::$definedVars); ?>' . $line['end'];
    }
}
