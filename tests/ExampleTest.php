<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function testTrueIsTrue(): void
    {
    // Introduce failure intentionally to simulate CI detecting test failure
    $this->assertFalse(true, 'Deliberate failing test for CI simulation');
    }
}
