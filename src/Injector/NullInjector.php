<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Injector;

/**
 * Do nothing
 */
class NullInjector implements ValueInjector
{
    /**
     * @inheritDoc
     */
    public function for(string $key, mixed $value): static
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function merge(array $values): array
    {
        return $values;
    }
}
