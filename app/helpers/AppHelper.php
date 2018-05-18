<?php
 namespace App\Helpers;

class AppHelper
{

    public static function getUserSessionHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/app/views/layouts/footer.blade.php';
        $contents = file_get_contents($path);
        $c_sha1 = sha1($contents);
        return substr($c_sha1, 0, 7);
    }

    public static function getShortName($phrase)
    {
        /**
         * Acronyms generator of a phrase
         */
        return preg_replace('~\b(\w)|.~', '$1', $phrase);
    }

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