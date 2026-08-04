<?php

declare(strict_types=1);

namespace Parses\Files;

function parses(string $content, string $format): array
{
    if ($format === 'json') {
        return json_decode($content, true);
    }

    throw new \Exception("Unknown format: {$format}");
}