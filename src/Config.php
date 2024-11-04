<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

use Mateodioev\MultiLang\Cache\{Cache, NullCache};
use Mateodioev\MultiLang\Injector\{NullInjector, ValueInjector};
use Mateodioev\MultiLang\Reader\{DefaultFileReader, FileReader};

/**
 * @api
 */
final class Config
{
    private static ?Config $instance = null;

    private ?FileReader $reader = null;
    private ?ValueInjector $injector = null;
    private ?Cache $cache = null;
    public bool $strictMode = true;

    private function __construct()
    {
    }

    public static function instance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function withFileReader(FileReader $reader): Config
    {
        $this->reader = $reader;
        return $this;
    }

    public function withInjector(ValueInjector $injector): Config
    {
        $this->injector = $injector;
        return $this;
    }

    public function withCache(Cache $cache): Config
    {
        $this->cache = $cache;
        return $this;
    }

    public function strictMode(bool $strictMode = true): Config
    {
        $this->strictMode = $strictMode;
        return $this;
    }

    public function reader(): FileReader
    {
        return $this->reader ?? new DefaultFileReader();
    }

    public function injector(): ValueInjector
    {
        return $this->injector ?? new NullInjector();
    }

    public function cache(): Cache
    {
        return $this->cache ?? new NullCache();
    }
}
