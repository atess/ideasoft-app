<?php

namespace Domain\Order\Http\Requests;

use Base\Concretes\BaseFormRequest;

class StoreDiscountRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'reason' => ['required'],
            'rules' => ['required', 'array'],
        ];
    }
}
