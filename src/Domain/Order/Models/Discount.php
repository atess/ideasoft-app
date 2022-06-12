<?php

namespace Domain\Order\Models;

use Base\Concretes\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property array $rules
 * @property string $reason
 */
class Discount extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'rules',
    ];

    protected $casts = [
        'rules' => 'array',
    ];
}
