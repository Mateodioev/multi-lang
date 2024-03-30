<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

use Exception;

final class InvalidDirectoryException extends Exception implements MultiLangExceptionInterface
{
    public static function at(string $directory): self
    {
        return new self("Directory \"$directory\" doesn't exists");
    }
}
