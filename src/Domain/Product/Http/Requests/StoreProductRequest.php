<?php

namespace Domain\Product\Http\Requests;

use Base\Concretes\BaseFormRequest;
use Domain\Product\Models\Category;
use Illuminate\Validation\Rule;

class StoreProductRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'price' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
            'stock' => ['required', 'integer'],
        ];
    }
}
