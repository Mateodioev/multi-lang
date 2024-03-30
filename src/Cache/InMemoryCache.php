<?php

declare (strict_types = 1);

namespace Mateodioev\MultiLang\Cache;

class InMemoryCache implements Cache
{
    private array $cache = [];

    public function get(string $key): mixed
    {
        return $this->cache[$key] ?? null;
    }

    public function set(string $key, mixed $value): void
    {
        $this->cache[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    public function clear(): void
    {
        $this->cache = [];
    }
}
