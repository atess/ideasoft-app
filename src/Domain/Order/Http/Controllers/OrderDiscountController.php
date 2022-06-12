<?php

namespace Domain\Order\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Domain\Order\Http\Resources\OrderDiscountResource;
use Support\DiscountHelper;

class OrderDiscountController extends BaseController
{
    public function __construct(protected DiscountServiceInterface $service)
    {
    }

    public function show(int $orderId): OrderDiscountResource
    {
        return OrderDiscountResource::make(
            (new DiscountHelper)
                ->setOrder($orderId)
                ->orderDiscounts()
        );
    }
}
