<?php
declare(strict_types=1);

namespace App\Helpers;


class PrintConsole
{
    public static function error($message) : void
    {
        echo "\033[1;37m\033[41m";
        echo $message;
        echo "\n\033[0m\r\n";
    }

    public static function info($message) : void
    {
        echo "\033[1;37m\033[46m";
        echo $message;
        echo "\n\033[0m\r\n";
    }
    
    public static function success($message) : void
    {
        echo "\033[1;37m\033[32m";
        echo $message;
        echo "\n\033[0m\r\n";
    }
}
