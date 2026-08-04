<?php

declare(strict_types=1);

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Files\differ;
use function PHPUnit\Framework\assertEquals;

class ParsesTest extends TestCase
{
    public function testCorrectParsesFiles(): void
    {
        $fileA = __DIR__ . '/fixtures/file1.json';
        $fileB = __DIR__ . '/fixtures/file2.json';

        $actual = differ($fileA, $fileB);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_flat.txt');

        assertEquals($expected, $actual);
    }
}