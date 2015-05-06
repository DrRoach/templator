<?php

class ParseElse
{
    public static function run($line)
    {
        if (Generate::$inForeach && Generate::$inForeach > Generate::$inIf) {
            Generate::$elseExists = true;
            //Foreach else
            return $line['start'] . '<?php endforeach; if(empty($' . Generate::$foreachVar . ')) : ?>' . $line['end'];
        }
        if(Generate::$inIf && Generate::$inIf > Generate::$inForeach) {
            //If else
            return $line['start'] . '<?php else : ?>' . $line['end'];
        }
    }
}