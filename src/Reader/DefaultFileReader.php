<?php

declare(strict_types=1);

namespace Mateodioev\MultiLang\Reader;

use Mateodioev\MultiLang\Exceptions\FileNotFoundException;

use function file_exists;
use function file_get_contents;

/**
 * Use {@see file_get_contents} to read a file
 */
class DefaultFileReader implements FileReader
{
    public function read(string $path): string
    {
        if (!file_exists($path)) {
            throw FileNotFoundException::notFound($path);
        }

        return file_get_contents($path);
    }
}
