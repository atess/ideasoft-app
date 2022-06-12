<?php

namespace Domain\Order\Models;

use Base\Concretes\BaseModel;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'unit_price',
        'total',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'float',
        'total' => 'float',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
