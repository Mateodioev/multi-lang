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
        return \json_encode([
            'englishName' => $this->englishName,
            'name' => $this->name,
            'shortName' => $this->shortName,
            'data' => \array_map(fn(DataAccessor $data) => $data->rawData, $this->data),
        ]);
    }

    /**
     * Return true if both languages contain the same data
     */
    public function compareData(Language $other): bool
    {
        foreach ($other->data as $key => $value) {
            if (\array_key_exists($key, $this->data) === false) {
                return false;
            }

            // Don't compare rawData because it's supposed to be in another language
            $diff = \array_diff($value->tokens(), $this->data($key)?->tokens() ?? []);
            if (\count($diff) !== 0) {
                return false;
            }
        }

        return true;
    }
}
