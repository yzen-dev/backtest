<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Class PrintConsole
 *
 * Вспомогательный сервис для вывода данных в консоль
 *
 * @package App\Helpers
 */
class PrintConsole
{
    /**
     * Вывод ошибки (красный фон)
     *
     * @param string $message Сообщение
     */
    public static function error($message): void
    {
        echo "\033[1;37m\033[41m";
        echo $message;
        echo "\n\033[0m\r\n";
    }

    /**
     * Вывод информации (синий фон)
     *
     * @param string $message Сообщение
     */
    public static function info($message): void
    {
        echo "\033[1;37m\033[46m";
        echo $message;
        echo "\n\033[0m\r\n";
    }

    /**
     * Вывод ошибки (зеленый фон)
     *
     * @param string $message Сообщение
     */
    public static function success($message): void
    {
        echo "\033[1;37m\033[42m";
        echo $message;
        echo "\n\033[0m\r\n";
    }
}
