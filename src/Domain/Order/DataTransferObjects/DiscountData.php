<?php

namespace Domain\Order\DataTransferObjects;

use Base\Concretes\BaseData;


class DiscountData extends BaseData
{
    public string $reason;

    public array $rules;
}
