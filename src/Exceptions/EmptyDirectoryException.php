<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Exceptions;

use InvalidArgumentException;

final class EmptyDirectoryException extends InvalidArgumentException implements MultiLangExceptionInterface
{
}
