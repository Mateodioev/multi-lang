<?php

declare (strict_types=1);

namespace Mateodioev\MultiLang;

class BulkBuilder
{
    /**
     * @var array<Builder>
     */
    private array $builders = [];

    public function addBuilder(Builder $builder): static
    {
        $this->builders[] = $builder;
        return $this;
    }

    /**
     * @return array<Language>
     */
    public function build(): array
    {
        return array_map(fn (Builder $builder) => $builder->build(), $this->builders);
    }

    public function save(string $directory): void
    {
        foreach ($this->builders as $builder) {
            $builder->save($directory . '/' . $builder->shortName . '.json');
        }
    }
}
