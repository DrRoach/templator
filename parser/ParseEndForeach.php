<?php

class ParseEndForeach
{
    public static function run($line)
    {
        //Check to make sure we're not in a foreach else
        if (Generate::$elseExists) {
            Generate::$elseExists = false;
            return $line['start'] . '<?php endif; ?>' . $line['end'];
        } else {
            Generate::$inForeach = 0;
            return $line['start'] . '<?php endforeach; ?>' . $line['end'];
        }
    }
}