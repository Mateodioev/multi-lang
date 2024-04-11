<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Parser;

use InvalidArgumentException;
use Mateodioev\MultiLang\Exceptions\FileException;
use Mateodioev\MultiLang\Reader\FileReader;
use Mateodioev\MultiLang\{DataAccessor, Language};

use function array_diff;
use function array_keys;
use function basename;
use function json_decode;

class FileParser
{
    public const ENGLISH_NAME = 'english_name';
    public const NAME = 'name';
    public const DATA = 'data';

    public const REQUIRED_PARAMETERS = [
        self::ENGLISH_NAME,
        self::NAME,
        self::DATA,
    ];

    /**
     * @var string The content of the file
     */
    private string $rawData;

    /**
     * @var array The decode json data
     */
    private array $jsonData;

    /**
     * @var string The file name without .json extension
     */
    public string $name;

    public function __construct(public string $file, FileReader $reader)
    {
        $this->rawData = $reader->read($file);
        $this->validateFile($this->rawData);

        $this->jsonData = json_decode($this->rawData, true, flags: JSON_THROW_ON_ERROR);
        $this->validateFile($this->jsonData);

        $this->name = basename($file, '.json');
        $this->checkRequiredParameters();
    }

    /**
     * @throws InvalidArgumentException If the $content is empty
     */
    private function validateFile(mixed $content): void
    {
        if (empty($content)) {
            throw FileException::empty($this->file);
        }
    }

    /**
     * Check if the file contain the necessary keys
     */
    private function checkRequiredParameters()
    {
        $keys = array_keys($this->jsonData);
        $difference = array_diff($keys, self::REQUIRED_PARAMETERS);

        if (empty($difference) === false) {
            throw FileException::invalid($this->file, $difference);
        }
    }

    /**
     * Convert the data to a language
     */
    public function getLanguage(): Language
    {
        return new Language(
            $this->jsonData[self::ENGLISH_NAME],
            $this->jsonData[self::NAME],
            $this->name,
            $this->parseData(),
        );
    }

    /**
     * @return array<string,DataAccessor>
     */
    private function parseData(): array
    {
        $datas = [];

        foreach ($this->jsonData[self::DATA] as $key => $value) {
            $datas[$key] = new DataAccessor($key, $value);
        }

        return $datas;
    }
}
