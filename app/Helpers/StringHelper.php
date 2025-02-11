<?php

namespace App\Helpers;

class StringHelper {
    public static function getBeforeWhitespace($string) {
        $position = strpos($string, ' ');
        if ($position === false) {
            // No whitespace found, return the whole string
            return $string;
        }
        return substr($string, 0, $position);
    }
}

