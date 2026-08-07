<?php

declare(strict_types=1);

namespace Differ\Files;

require_once __DIR__ . '/Format.php';

use function Format\Value\formatValue;
use function Parses\Files\parses;

function differ(string $file1, string $file2): string
{
    $content1 = file_get_contents($file1);
    $content2 = file_get_contents($file2);
    $format1 = pathinfo($file1, PATHINFO_EXTENSION);
    $format2 = pathinfo($file2, PATHINFO_EXTENSION);
    $parse1 = parses($content1, $format1);
    $parse2 = parses($content2, $format2);
    $keys1 = array_keys($parse1);
    $keys2 = array_keys($parse2);
    $allKeys = array_unique(array_merge($keys1, $keys2));
    sort($allKeys);

    $lines = array_map(function ($key) use ($parse1, $parse2) {
        $hasIn1 = array_key_exists($key, $parse1);
        $hasIn2 = array_key_exists($key, $parse2);
        if ($hasIn1 && $hasIn2) {
            $val1 = $parse1[$key];
            $val2 = $parse2[$key];
            if ($val1 === $val2) {
                return "    {$key}: " . formatValue($val1);
            }
            return "  - {$key}: " . formatValue($val1) . "\n  + {$key}: " . formatValue($val2);
        }
        if ($hasIn1) {
            return "  - {$key}: " . formatValue($parse1[$key]);
        }
        return "  + {$key}: " . formatValue($parse2[$key]);
    }, $allKeys);

    return "{\n" . implode("\n", $lines) . "\n}";
}