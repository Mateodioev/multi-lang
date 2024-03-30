<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

use RuntimeException;

class LanguageTokenMismatchException extends RuntimeException implements MultiLangExceptionInterface
{
    public static function at(string $language, string $otherLanguage, string $key, array $diff, array $languageTokens): self
    {
        return new self(
            "$language contain different data than $otherLanguage in key \"$key\" with values"
            . ' [' . \join(', ', $diff) . '] in ' . $otherLanguage . ' and [' . join(', ', $languageTokens) . ']'
            . ' in ' . $otherLanguage
        );
    }
}
