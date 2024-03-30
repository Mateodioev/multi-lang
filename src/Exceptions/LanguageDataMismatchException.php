<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang\Exceptions;

class LanguageDataMismatchException extends \RuntimeException implements MultiLangExceptionInterface
{
    public static function at(string $shortName, string $key): self
    {
        return new self("Language $shortName doesn't contain key $key");
    }
}
