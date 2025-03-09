<?php

namespace App\Tools;

class Helpers{

    public static function format($text)
    {
        return str_replace(' ', '_', strtolower(trim($text)));
    }

}
