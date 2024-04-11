<?php

declare(strict_types=1);

namespace Mateodioev\MultiLang\Reader;

use Mateodioev\MultiLang\Exceptions\FileNotFoundException;

interface FileReader
{
    /**
     * Read the content of a file.
     * @throws FileNotFoundException If the file does not exist.
     */
    public function read(string $path): string;
}
