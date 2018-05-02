<?php
/**
 * Created by PhpStorm.
 * User: hbot
 * Date: 3/3/18
 * Time: 1:21 PM
 */

class SmsHelper
{

    public static function clockalize($in)
    {

        $h = intval($in);
        $m = round((((($in - $h) / 100.0) * 60.0) * 100), 0);
        if ($m == 60) {
            $h++;
            $m = 0;
        }
        $retval = sprintf("%2dH%2dM", $h, $m);
        return $retval;
    }

}