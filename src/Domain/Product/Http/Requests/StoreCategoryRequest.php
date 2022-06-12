<?php

namespace Domain\Product\Http\Requests;

use Base\Concretes\BaseFormRequest;

class StoreCategoryRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}
