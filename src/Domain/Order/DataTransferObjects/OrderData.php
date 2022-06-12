<?php

namespace Domain\Order\DataTransferObjects;

use Base\Concretes\BaseData;
use Spatie\DataTransferObject\Attributes\CastWith;

class OrderData extends BaseData
{
    /** @var OrderProductData[] */
    #[CastWith(ProductArrayCaster::class)]
    public array $products;
}
