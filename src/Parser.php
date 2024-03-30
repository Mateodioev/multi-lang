<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

use InvalidArgumentException;
use Mateodioev\MultiLang\Exceptions\{EmptyDirectoryException, InvalidDirectoryException};
use Mateodioev\MultiLang\Parser\FileParser;

use function glob;
use function is_dir;

/**
 * Load and parse files
 */
class Parser
{
    /**
     * @var string[] $files
     */
    private array $files;

    /**
     * @param string $directory The directory containing the json files
     * @throws InvalidArgumentException If the directory doesn't exists
     */
    public function __construct(private string $directory)
    {
        if (is_dir($this->directory) === false) {
            throw InvalidDirectoryException::at($directory);
        }

        $this->files = glob($this->directory . "/*.json");
        // Check if the directory is empty
        $this->validateDirectory();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateDirectory(): void
    {
        if (empty($this->files)) {
            throw new EmptyDirectoryException();
        }
    }

    /**
     * @return array<string,FileParser>
     */
    public function langs(): array
    {
        $langs = [];

        foreach ($this->files as $file) {
            $fileParser = new FileParser($file);
            $langs[$fileParser->name] = $fileParser;
        }

        return $langs;
    }
}
