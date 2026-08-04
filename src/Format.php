<?php

declare(strict_types=1);

namespace Format\Value;

function formatValue(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false'; // Превращаем в честную строку 'true' или 'false'
    }
    
    if (is_null($value)) {
        return 'null'; // Превращаем в честную строку 'null'
    }

    return (string) $value; // Все остальные типы (числа, строки) преобразуем как обычно
}