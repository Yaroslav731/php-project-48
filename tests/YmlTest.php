<?php

declare(strict_types=1);

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Files\differ;
use function PHPUnit\Framework\assertEquals;

class YmlTest extends TestCase
{
    public function testCorrectParsesYml(): void
    {
        $fileA = __DIR__ . '/fixtures/file3.yml';
        $fileB = __DIR__ . '/fixtures/file4.yml';

        $expected = file_get_contents(__DIR__ . '/fixtures/expected_flat.txt');
        $actual = (differ($fileA, $fileB));
        assertEquals($expected, $actual);
    }
}