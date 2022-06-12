<?php

namespace Base\Exceptions;


use Base\Concretes\BaseException;

class KeyNotFoundException extends BaseException
{
    public function defaultMessage(): string
    {
        return __('findFromMixed key not found.');
    }

    public function defaultCode(): int
    {
        return 500;
    }
}
