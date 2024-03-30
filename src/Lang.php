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
        if (self::$parser === null) {
            throw new \RuntimeException('You must call Lang::setup() before');
        }
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
}
