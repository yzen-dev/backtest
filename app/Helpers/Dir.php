<?php
declare(strict_types=1);

namespace App\Helpers;


/**
 * Class Dir
 * @package App\Helpers
 */
class Dir
{
    /**
     * Создать директорию
     * @param string $dir Путь к директории
     */
    public static function mkdir($dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir);
        }
    }

    /**
     * Удалить директорию
     *
     * @param string $dir Путь к директории
     */
    public static function rmdir($dir): void
    {
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    /**
     * Рекурсивное удаление директории вместе с файлами
     *
     * @param string $dir Путь к директории
     */
    public static function rmdirRecursive($dir): void
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? self::rmdirRecursive("$dir/$file") : unlink("$dir/$file");
            }
            rmdir($dir);
        }
    }
}
