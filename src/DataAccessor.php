<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Parser\StringParser;

class DataAccessor
{
    private StringParser $parser;

    public function __construct(public string $key, public string $rawData)
    {
        $this->parser = new StringParser($rawData);
    }

    /**
     * Format the rawData with the params
     *
     * @param array<string, string> $params
     *
     * Example:
     *
     * ```php
     * (new DataAccessor(key: 'start', rawData: 'Hi, welcome to bot {name}'))
     *     ->format(['the bot name here']);
     *
     * // output: Hi, welcome to bot the bot name here
     * ```
     */
    public function format(array $params = []): string
    {
        $params = Lang::$injector->merge($params);
        return $this->parser->format($params);
    }

    /**
     * Get the tokens in {static::rawData}
     * @return string[]
     */
    public function tokens(): array
    {
        return $this->parser->tokens();
    }

    /**
     * Return raw data
     */
    public function __toString(): string
    {
        return $this->rawData;
    }
}
