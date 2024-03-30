<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang;

class Language
{
    /**
     * @param string $englishName The name in english
     * @param string $name The original name
     * @param string $shortName The short name of the language
     * @param array<string, DataAccessor> $data Contain the data
     */
    public function __construct(
        public string $englishName,
        public string $name,
        public string $shortName,
        public array $data,
    ) {
    }

    /**
     * Find key in data
     *
     * @param string $key
     * @return ?DataAccessor Return null if key doesn't exists
     */
    public function data(string $key): ?DataAccessor
    {
        return $this->data[$key] ?? null;
    }

    public function toJson(): string
    {
        return \json_encode(
            value: [
                'englishName' => $this->englishName,
                'name' => $this->name,
                'shortName' => $this->shortName,
                'data' => \array_map(fn(DataAccessor $data) => $data->rawData, $this->data),
            ],
            flags: \JSON_THROW_ON_ERROR  | \JSON_UNESCAPED_UNICODE  | \JSON_PRETTY_PRINT,
        );
    }

    /**
     * @throws \RuntimeException If the data is different
     * @throws \RuntimeException If tokens are different
     */
    public function compareData(Language $other): void
    {
        foreach ($other->data as $key => $value) {
            if (\array_key_exists($key, $this->data) === false) {
                throw new \RuntimeException("Language {$this->shortName} doesn't contain key $key");
            }

            // Don't compare rawData because it's supposed to be in another language
            $actualTokens = $this->data($key)?->tokens() ?? [];
            $diff = \array_diff($value->tokens(), $actualTokens);
            if (\count($diff) !== 0) {
                $exceptionMessage = $this->englishName . ' contain different data than ' . $other->englishName
                . ' in key "' . $key . '" with values [' . \implode(', ', $diff) . '] in '
                . $this->englishName . ' and [' . \implode(', ', $actualTokens) . '] in ' . $other->englishName;
                throw new \RuntimeException($exceptionMessage);
            }
        }
    }
}
