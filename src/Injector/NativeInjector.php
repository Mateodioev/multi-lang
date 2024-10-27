<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang\Injector;

use function array_map;
use function array_merge;

class NativeInjector implements ValueInjector
{
    private array $values = [];

    /**
     * @inheritDoc
     */
    public function for(string $key, mixed $value): static
    {
        $this->values[$key] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function merge(array $values): array
    {
        $computedValues = array_map(
            callback: fn ($value): string => $this->transformValue($value),
            array:$this->values,
        );

        return array_merge($values, $computedValues);
    }

    private function transformValue(mixed $value): string
    {
        if (is_callable($value)) {
            return $value();
        }

        return $value;
    }
}
