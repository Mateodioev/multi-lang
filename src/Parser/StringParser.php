<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Parser;

use Mateodioev\MultiLang\Config;
use Mateodioev\MultiLang\Exceptions\InvalidFormatParamsException;

class StringParser
{
    private ?array $tokens = null;
    public function __construct(private string $rawData)
    {
    }

    /**
     * Example:
     *
     * ```php
     * (new StringParser('This is an example using {params}'))
     *   ->format(['params' => StringParser::class]);
     * ```
     */
    public function format(array $params): string
    {
        $this->checkParams($params);

        return preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($params) {
            $key = $matches[1];
            return $params[$key] ?? $matches[0];
        }, $this->rawData);
    }

    /**
     * Check if exists the params in tokens
     */
    private function checkParams(array $params): void
    {
        $diff = array_diff(array_keys($params), $this->tokens());
        if (count($diff) > 0 && Config::instance()->strictMode) {
            throw InvalidFormatParamsException::for($diff);
        }
    }

    /**
     * Example:
     *
     * ```php
     * (new StringParser('This is an example using {params}'))
     *   ->tokens();
     * // output: ['params']
     * ```
     *
     * @return string[]
     */
    public function tokens(): array
    {
        if ($this->tokens !== null) {
            return $this->tokens;
        }

        $this->tokens = [];
        preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $this->rawData, $matches);
        $this->tokens = $matches[1];

        return $this->tokens;
    }
}
