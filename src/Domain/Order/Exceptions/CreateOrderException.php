<?php

namespace Domain\Order\Exceptions;


use Base\Concretes\BaseException;

class CreateOrderException extends BaseException
{
    public function defaultMessage(): string
    {
        return __('Order could not be created.');
    }

    public function defaultCode(): int
    {
        return 500;
    }
}
