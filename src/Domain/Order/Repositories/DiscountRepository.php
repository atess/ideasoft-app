<?php

namespace Domain\Order\Repositories;

use Base\Concretes\BaseRepository;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;
use Domain\Order\Models\Discount;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }
}
