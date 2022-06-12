<?php

namespace Domain\Order\Repositories;

use Base\Concretes\BaseRepository;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;
use Domain\Order\Models\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}
