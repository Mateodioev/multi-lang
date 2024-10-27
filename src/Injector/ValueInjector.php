<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Injector;

/**
 * Inject values in {@see DataAccessor::format}
 */
interface ValueInjector
{
    /**
     * Inject a value for a key
     *
     * @param string $key
     * @param mixed $value can be a native type or a callable
     *
     * @return static
     */
    public function for(string $key, mixed $value): static;

    /**
     * Merge the values
     * @param array $values the values to merge
     * @return array<string, mixed>
     */
    public function merge(array $values): array;
}
