<?php

namespace Domain\Order\DataTransferObjects;

use Exception;
use Spatie\DataTransferObject\Caster;

class ProductArrayCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    public function cast(mixed $value): array
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to OrderProductData");
        }

        return array_map(
            fn (array $data) => new OrderProductData(...$data),
            $value
        );
    }
}
