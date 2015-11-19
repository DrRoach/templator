<?php

class ParseForeach
{
    public static function run($line)
    {
        $split = explode('.', $line['array']);
        $array = '';

        foreach ($split as $pos => $var) {
            if ($pos == 0) {
                $array .= '$'.$var;
            } else {
                $array .= $var . "']";
            }
            if ((sizeof($split) - 1) > $pos && sizeof($split) > 1) {
                $array .= "['";
            }
        }

        $echo = '<?php foreach(' . $array . ' as $' . $line['var'] . (!empty($line['subVar']) ? ' => $'.$line['subVar'] : '') .') : ?>';

        return $line['start'] . $echo . $line['end'];
    }
}