<?php

namespace Domain\Order\Exceptions;


use Base\Concretes\BaseException;

class OutOfStockException extends BaseException
{
    public function defaultMessage(): string
    {
        return __('Out of stock.');
    }

    public function defaultCode(): int
    {
        return 400;
    }
}
