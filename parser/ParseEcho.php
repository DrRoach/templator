<?php

class ParseEcho
{
    public static function run($line)
    {
        $split = explode('.', $line['echo']);
        $echo = '<?= ';
        //Escape the HTML
        $echo .= self::escape(true, $line);
        foreach ($split as $pos => $var) {
            if ($pos == 0) {
                $echo .= '$'.$var;
            } else {
                $echo .= $var . "']";
            }
            if ((sizeof($split) - 1) > $pos && sizeof($split) > 1) {
                $echo .= "['";
            }
        }
        //Escape the HTML
        $echo .= self::escape(false, $line);
        $echo .= '; ?>';
        return $line['start'] . $echo .  $line['end'];
    }

    /**
     * @param boolean $beginning
     */
    public static function escape($beginning, $line)
    {
        switch($line['escape']) {
        case '|e':
        case '|escape':
        case '!e':
        case '!escape':
            return '';
        default:
            if (empty($line['startQuickEsc']) && empty($line['endQuickEsc'])) {
                if ($beginning) {
                    return 'htmlspecialchars(';
                } else {
                    return ')';
                }
            } else {
                return '';
            }
        }
    }
}
