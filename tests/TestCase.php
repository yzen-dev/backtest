<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        if (!is_dir('tmp')) {
            mkdir('tmp');
        }
        parent::setUp();
    }

    /*public static function tearDownAfterClass(): void
    {
        rmdir('tmp');
    }*/

    protected function tearDown(): void
    {
        if (is_dir('tmp')) {
            self::delTree('tmp');
        }
        parent::tearDown();
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
