<?php

namespace App\Helpers;

class Dumper
{

    public static function dd($var): void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}