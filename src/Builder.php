<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Exceptions\RequiredParamException;
use Mateodioev\MultiLang\Parser\FileParser;

use function file_put_contents;

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

    /**
     * @throws RequiredParamException If a required param is missing
     */
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
        return file_put_contents($fileName, $this->build()->toJson()) !== false;
    }

    private function checkParams(): void
    {
        if (empty($this->englishName)) {
            throw RequiredParamException::for('englishName');
        }

        if (empty($this->name)) {
            throw RequiredParamException::for('name');
        }

        if (empty($this->shortName)) {
            throw RequiredParamException::for('shortName');
        }

        if (empty($this->data)) {
            throw RequiredParamException::for('data');
        }
    }
}
