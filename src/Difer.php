<?php

declare(strict_types=1);

namespace Differ\Files;

use function Funct\Collection\sortBy;
use function Format\Value\formatValue;

function differ(string $file1, string $file2): string
{
    $content1 = file_get_contents($file1);
    $content2 = file_get_contents($file2);
    $parse1 = json_decode($content1, true);
    $parse2 = json_decode($content2, true);
    $keys1 = array_keys($parse1);
    $keys2 = array_keys($parse2);
    $allKeys = array_unique(array_merge($keys1, $keys2));
    $sortKeys = sortBy($allKeys, function ($key) {
        return $key;
    });
    $sortKeys = array_values($sortKeys);

    $lines = array_map(function ($key) use ($parse1, $parse2) {
        $hasIn1 = array_key_exists($key, $parse1);
        $hasIn2 = array_key_exists($key, $parse2);
        if ($hasIn1 && $hasIn2) {
            $val1 = formatValue($parse1[$key]);
            $val2 = formatValue($parse2[$key]);
            if ($val1 === $val2) {
                return "    {$key}: {$val1}";
            }
            return "  - {$key}: {$val1}\n  + {$key}: {$val2}";
        }
        if ($hasIn1) {
            $val1 = formatValue($parse1[$key]);
            return "  - {$key}: {$val1}";
        }
        $val2 = formatValue($parse2[$key]);
        return "  + {$key}: {$val2}";
    }, $sortKeys);

    return "{\n" . implode("\n", $lines) . "\n}";
}