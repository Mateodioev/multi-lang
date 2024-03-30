<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Cache\Cache;
use Mateodioev\MultiLang\Cache\NullCache;

final class Lang
{
    private static ?Parser $parser = null;
    private static Cache $cache;

    public static function setup(string $dir, Cache $cache = new NullCache()): void
    {
        self::$parser = new Parser($dir);
        self::$cache = $cache;
    }

    public static function get(string $shortName): ?Language
    {
        static::checkParser();

        if (self::$cache->has($shortName)) {
            return self::$cache->get($shortName);
        }

        $langs = self::$parser->langs();
        $language = ($langs[$shortName] ?? null)?->getLanguage();

        if ($language !== null) {
            self::$cache->set($shortName, $language);
        }

        return $language;
    }

    /**
     * Check if all languages contain the same data and same tokens
     */
    public static function compareData(): void
    {
        static::checkParser();

        $langs = [];
        foreach (self::$parser->langs() as $_lang) {
            $lang = $_lang->getLanguage();
            self::$cache->set($lang->shortName, $lang);
            $langs[] = $lang;
        }

        // Check if all languages contain the same data
        $count = count($langs);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $actual = $langs[$i];
                $other = $langs[$j];

                $actual->compareData($other);
            }
        }
    }

    private static function checkParser(): void
    {
        if (self::$parser === null) {
            throw new \RuntimeException('You must call Lang::setup() before');
        }
    }
}
