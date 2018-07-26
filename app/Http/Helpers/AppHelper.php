<?php
 namespace App\Http\Helpers;

class AppHelper
{

    public static function getUserSessionHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/resources/views/backend/partial/footer.blade.php';
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

}