<?php

class ParseForeach
{
    public static function run($line)
    {
        $echo = '<?php foreach($' . $line['array'] . ' as $' . $line['var'] . (!empty($line['subVar']) ? ' => $'.$line['subVar'] : '') .') : ?>';

        return $line['start'] . $echo . $line['end'];
    }
}