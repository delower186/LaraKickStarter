<?php

namespace App\Tools;
use App\Models\Configuration;

class Helpers{

    public static function format($text, $separator = "_")
    {
        return str_replace(' ', $separator, strtolower(trim($text)));
    }

    public static function getValue($key, $default = null):string{

        $config = Configuration::first();

        return $config->{$key} ?? $default;
    }

}
