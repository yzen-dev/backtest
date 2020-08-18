<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        if (!is_dir('tmp')) {
            mkdir('tmp');
        }
        parent::setUp();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        if (is_dir('tmp')) {
            self::delTree('tmp');
        }
        parent::tearDown();
    }

    /**
     * Рекурсивное удаление директории вместе с файлами
     * @param string $dir Директория которую необходимо удалить
     * @return bool
     */
    public static function delTree(string $dir): bool
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
