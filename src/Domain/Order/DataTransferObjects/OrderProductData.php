<?php

namespace Domain\Order\DataTransferObjects;

use Base\Concretes\BaseData;

class OrderProductData extends BaseData
{
    public int $product_id;
    public int $quantity;
}
