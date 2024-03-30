<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang\Parser;

use Mateodioev\MultiLang\DataAccessor;
use Mateodioev\MultiLang\Language;

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

    public function __construct(public string $file)
    {
        $this->rawData = \file_get_contents($file);
        $this->validateFile($this->rawData);

        $this->jsonData = \json_decode($this->rawData, true, flags: JSON_THROW_ON_ERROR);
        $this->validateFile($this->jsonData);

        $this->name = \basename($file, '.json');
        $this->checkRequiredParameters();
    }

    /**
     * @throws \InvalidArgumentException If the $content is empty
     */
    private function validateFile(mixed $content): void
    {
        if (empty($content)) {
            throw new \InvalidArgumentException('Empty json "' . \basename($this->file) . '" file');
        }
    }

    /**
     * Check if the file contain the necessary keys
     */
    private function checkRequiredParameters()
    {
        $keys = \array_keys($this->jsonData);
        $difference = \array_diff($keys, self::REQUIRED_PARAMETERS);

        if (empty($difference) === false) {
            $unknownKeys = \join(',', $difference);
            throw new \InvalidArgumentException('Unknown keys ' . $unknownKeys . ' in lang ' . $this->name);
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
