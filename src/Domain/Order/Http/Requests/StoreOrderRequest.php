<?php

namespace Domain\Order\Http\Requests;

use Base\Concretes\BaseFormRequest;
use Domain\Product\Models\Product;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', Rule::exists(Product::class, 'id')],
            'products.*.quantity' => ['required', 'integer'],
        ];
    }
}
