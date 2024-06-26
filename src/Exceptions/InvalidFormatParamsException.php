<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

use InvalidArgumentException;

class InvalidFormatParamsException extends InvalidArgumentException implements MultiLangExceptionInterface
{
    /**
     * @param string[] $params
     */
    public static function for(array $params): static
    {
        return new static('The following parameters are not in the tokens: ' . join(', ', $params));
    }
}
