<?php

namespace Tests;

use App\Helpers\Dir;
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
        Dir::mkdir('tmp');
        parent::setUp();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        Dir::rmdirRecursive('tmp');
        parent::tearDown();
    }
}
