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

class ArrayHelper{
    public static function convertArraytoInteger($arrofNumbers){
        $number = (int) array_reduce($arrofNumbers, function($acc, $el){
            $acc .= $el;
            return $acc;
        });

        return $number;
    }

    public static function maptoArray($items, $key)
    {
        return array_map(function ($item) use ($key) {
            return [$key => $item];
        }, $items);
    }
}

