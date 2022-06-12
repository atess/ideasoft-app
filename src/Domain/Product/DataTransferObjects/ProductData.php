<?php

namespace Domain\Product\DataTransferObjects;

use Base\Concretes\BaseData;


class ProductData extends BaseData
{
    public string $name;
    public int $category_id;
    public string $price;
    public int $stock;
}
