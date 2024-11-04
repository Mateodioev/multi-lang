<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Cache\Cache;

use Mateodioev\MultiLang\Reader\FileReader;
use RuntimeException;

final class Lang
{
    private static ?Parser $parser = null;

    /**
     * @param string $dir
     * @param Cache $cache Where to store the languages
     * @param FileReader $reader Use to get the content of the language files
     * @return void
     */
    public static function setup(
        string $dir,
        ?Config $config,
    ): void {
        self::$parser = new Parser($dir, $config?->reader() ?? Config::instance()->reader());
    }

    public static function get(string $shortName): ?Language
    {
        static::checkParser();

        $config = Config::instance();

        if ($config->cache()->has($shortName)) {
            return $config->cache()->get($shortName);
        }

        $langs = self::$parser->langs();
        $language = ($langs[$shortName] ?? null)?->getLanguage();

        if ($language !== null) {
            $config->cache()->set($shortName, $language);
        }

        return $language;
    }

    /**
     * Get all languages
     *
     * @return array<string,Language>
     */
    public static function all(): array
    {
        static::checkParser();

        $langs = array_map(function ($_lang) {
            $lang = $_lang->getLanguage();
            Config::instance()->cache()->set($lang->shortName, $lang);
            return $lang;
        }, self::$parser->langs());

        return $langs;
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
            Config::instance()->cache()->set($lang->shortName, $lang);
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
            throw new RuntimeException('You must call Lang::setup() before');
        }
    }
}
