<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

use InvalidArgumentException;

class FileException extends InvalidArgumentException implements MultiLangExceptionInterface
{
    public static function empty(string $file): static
    {
        return new static("The json file \"$file\" is empty");
    }

    public static function invalid(string $file, array $keys): static
    {
        $unknownKeys = join(', ', $keys);
        return new static("The json file \"$file\" contain unknown keys: $unknownKeys");
    }
}
