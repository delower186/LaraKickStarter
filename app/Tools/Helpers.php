<?php

namespace App\Tools;

class Helpers{

    public static function format($text, $separator = "_")
    {
        return str_replace(' ', $separator, strtolower(trim($text)));
    }

}
