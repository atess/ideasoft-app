<?php

namespace Domain\Order\Models;

use App\Traits\Eloquent\CreatedBy;
use App\Traits\Eloquent\DeletedBy;
use Base\Concretes\BaseModel;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $items
 */
class Order extends BaseModel
{
    use HasFactory;
    use CreatedBy, DeletedBy;

    protected $fillable = [
        'user_id',
        'total',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'total' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
