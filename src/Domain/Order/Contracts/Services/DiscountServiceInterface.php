<?php

namespace Domain\Order\Contracts\Services;

use Base\Contracts\BaseServiceInterface;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;

interface DiscountServiceInterface extends BaseServiceInterface
{
    public function __construct(DiscountRepositoryInterface $repository);
}
