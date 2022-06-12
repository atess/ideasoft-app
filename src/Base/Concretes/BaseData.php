<?php

namespace Base\Concretes;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class BaseData extends DataTransferObject
{
    protected array $filledKeys;

    /**
     * @throws UnknownProperties
     */
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $this->filledKeys = array_keys($args);

        parent::__construct(...$args);
    }

    public function onlyFilled(): static
    {
        return $this->only(...$this->filledKeys);
    }

    public function has(string $key): bool
    {
        return property_exists($this, $key);
    }
}
