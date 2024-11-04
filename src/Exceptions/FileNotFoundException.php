<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

class FileNotFoundException extends FileException
{
    public static function notFound(string $file): static
    {
        return new static("The file \"$file\" not found");
    }
}
