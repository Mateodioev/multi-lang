<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang\Exceptions;

class RequiredParamException extends \InvalidArgumentException implements MultiLangExceptionInterface
{
    public static function for(string $param): self
    {
        return new self("Parameter \"$param\" is required");
    }
}
