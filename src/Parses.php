<?php

declare(strict_types=1);

namespace Parses\Files;

use Symfony\Component\Yaml\Yaml;

function parses(string $content, string $format): array
{
    if ($format === 'json') {
        return json_decode($content, true);
    }
    if ($format === 'yaml' || $format === 'yml') {
        return (array) Yaml::parse($content);
    }

    throw new \Exception("Unknown format: {$format}");
}