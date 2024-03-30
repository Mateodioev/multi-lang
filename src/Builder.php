<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Parser\FileParser;

/**
 * Language builder
 */
class Builder
{

    public static function fromLanguage(Language $lang): static
    {
        $builder = new static();

        $builder->englishName = $lang->englishName;
        $builder->name = $lang->name;
        $builder->shortName = $lang->shortName;
        $builder->data = $lang->data;

        return $builder;
    }

    public static function fromFile(string $filePath): static
    {
        $parser = new FileParser($filePath);
        return static::fromLanguage($parser->getLanguage());
    }

    public string $englishName = '';
    public string $name = '';
    public string $shortName = '';
    /**
     * @var array<string, DataAccessor>
     */
    public array $data = [];

    public function addData(string $key, string $value): static
    {
        $this->data[$key] = new DataAccessor($key, $value);
        return $this;
    }

    public function build(): Language
    {
        $this->checkParams();
        return new Language(
            $this->englishName,
            $this->name,
            $this->shortName,
            $this->data,
        );
    }

    public function save(string $fileName): bool
    {
        return \file_put_contents($fileName, $this->build()->toJson()) !== false;
    }

    private function checkParams(): void
    {
        if (empty($this->englishName)) {
            throw new \InvalidArgumentException('The english name is required');
        }

        if (empty($this->name)) {
            throw new \InvalidArgumentException('The name is required');
        }

        if (empty($this->shortName)) {
            throw new \InvalidArgumentException('The short name is required');
        }

        if (empty($this->data)) {
            throw new \InvalidArgumentException('The data is required');
        }
    }
}
