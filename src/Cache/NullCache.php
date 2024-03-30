<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Cache;

/**
 * blackhole cache
 */
class NullCache implements Cache
{
    public function get(string $key): mixed
    {
        return null;
    }

    public function set(string $key, mixed $value): void
    {
    }

    public function has(string $key): bool
    {
        return false;
    }

    public function clear(): void
    {
    }
}
